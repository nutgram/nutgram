<?php

declare(strict_types=1);

namespace SergiX44\Nutgram;

use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use Psr\Clock\ClockInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Container\Container;
use SergiX44\Hydrator\Hydrator;
use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Handlers\FireHandlers;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\Handlers\Type\InternalCommand;
use SergiX44\Nutgram\Proxies\GlobalCacheProxy;
use SergiX44\Nutgram\Proxies\UpdateDataProxy;
use SergiX44\Nutgram\Proxies\UserCacheProxy;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Support\BulkMessenger;
use SergiX44\Nutgram\Support\HandleLogging;
use SergiX44\Nutgram\Support\SystemClock;
use SergiX44\Nutgram\Support\ValidatesWebData;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\RegisteredCommand;
use SergiX44\Nutgram\Testing\FakeNutgram;
use Throwable;
use function Opis\Closure\init;

class Nutgram extends ResolveHandlers
{
    use Client;
    use UpdateDataProxy;
    use GlobalCacheProxy;
    use UserCacheProxy;
    use FireHandlers;
    use ValidatesWebData;
    use HandleLogging;

    private string $token;

    protected Configuration $config;

    private Guzzle $http;

    protected Hydrator $hydrator;

    protected Container $container;

    /**
     * Nutgram constructor.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(string $token, ?Configuration $config = null)
    {
        $this->validateToken($token);

        $this->bootstrap($token, $config ?? new Configuration());
    }

    /**
     * Initializes the current instance
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function bootstrap(string $token, Configuration $config): void
    {
        $this->token = $token;
        $this->config = $config;
        $this->container = new Container();
        if ($config->container !== null) {
            $this->container->delegate($config->container);
        }

        init($this->token, true);

        $this->http = new Guzzle([
            'base_uri' => sprintf(
                '%s/bot%s/%s',
                $config->apiUrl,
                $this->token,
                $config->testEnv ? 'test/' : ''
            ),
            'timeout' => $config->clientTimeout,
            'version' => $config->enableHttp2 ? '2.0' : '1.1',
            ...$config->clientOptions,
        ]);
        $this->container->set(ClientInterface::class, $this->http);
        $this->container->set(ClockInterface::class, new SystemClock());
        $this->container->singleton(CacheInterface::class, $config->cache);
        $this->container->singleton(LoggerInterface::class, $config->logger);
        $this->container->singleton(
            ConversationCache::class,
            fn (ContainerInterface $c): ConversationCache => new ConversationCache(
                cache: $c->get(CacheInterface::class),
                botId: $this->getBotId(),
                ttl: $config->conversationTtl,
            )
        );
        $this->container->singleton(GlobalCache::class, fn (ContainerInterface $c): GlobalCache => new GlobalCache(
            cache: $c->get(CacheInterface::class),
            botId: $this->getBotId(),
        ));
        $this->container->singleton(UserCache::class, fn (ContainerInterface $c): UserCache => new UserCache(
            cache: $c->get(CacheInterface::class),
            botId: $this->getBotId(),
        ));

        $this->hydrator = new Hydrator($this->container);

        $this->container->singleton(RunningMode::class, Polling::class);
        $this->container->set(self::class, $this);
    }

    public function getBotId(): int
    {
        return (int)explode(':', $this->token)[0];
    }

    public function __serialize(): array
    {
        return [
            'token' => $this->token,
            'config' => $this->config,
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __unserialize(array $data): void
    {
        $this->bootstrap($data['token'], $data['config']);
    }

    public static function fake(mixed $update = null, array $responses = [], ?Configuration $config = null): FakeNutgram
    {
        return FakeNutgram::instance($update, $responses, $config);
    }

    public function setRunningMode(string|RunningMode $classOrInstance): void
    {
        $this->container->bind(RunningMode::class, $classOrInstance);
    }

    protected function preflight(): void
    {
        if (!$this->finalized) {
            $this->resolveGroups();
            $this->applyGlobalMiddleware();
            $this->finalized = true;
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        $this->preflight();
        $this->container->get(RunningMode::class)->processUpdates($this);
    }

    /**
     * @throws Throwable
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdate(Update $update): void
    {
        $this->setContextUpdate($update);

        $conversation = $this->currentConversation($this->userId(), $this->chatId(), $this->messageThreadId());

        if ($conversation !== null) {
            $handlers = $this->continueConversation($conversation);
        } else {
            $handlers = $this->resolveHandlers();
        }

        if (empty($handlers) && !empty($this->handlers[self::FALLBACK])) {
            $this->addHandlersBy($handlers, self::FALLBACK, value: $this->update->getType()->value);
        }

        if (empty($handlers)) {
            $this->addHandlersBy($handlers, self::FALLBACK);
        }

        $this->fireHandlers($handlers);
    }

    public function setContextUpdate(Update $update): void
    {
        $this->update = $update;
    }

    /**
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function stepConversation(
        Conversations\Conversation|callable $callable,
        ?int $userId = null,
        ?int $chatId = null,
        ?int $threadId = null,
    ): self {
        $userId ??= $this->userId();
        $chatId ??= $this->chatId();
        $threadId ??= $this->messageThreadId();

        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot step a conversation without userId and chatId.');
        }

        $this->container->get(ConversationCache::class)->set($userId, $chatId, $threadId, $callable);

        return $this;
    }

    /**
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function endConversation(?int $userId = null, ?int $chatId = null, ?int $threadId = null): self
    {
        $userId ??= $this->userId();
        $chatId ??= $this->chatId();

        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot end a conversation without userId and chatId.');
        }

        $this->container->get(ConversationCache::class)->delete($userId, $chatId, $threadId);

        return $this;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function getHydrator(): Hydrator
    {
        return $this->hydrator;
    }

    public function bindParameter(string $name, callable $resolver): \SergiX44\Container\Definition
    {
        return $this->container->bind("param.$name", $resolver);
    }

    public function getConfig(): Configuration
    {
        return $this->config;
    }

    public function getInstance(): Nutgram
    {
        return $this;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRunningMode(): string
    {
        return $this->container->get(RunningMode::class)::class;
    }

    /**
     * Set my commands call to Telegram using all the registered commands
     * @return RegisteredCommand[]
     */
    public function registerMyCommands(): array
    {
        $this->preflight();

        /**
         * @var array<string, array{scopes:array<string,BotCommandScope>, commands:array<string, BotCommand[]>}> $myCommands
         */
        $myCommands = [];
        array_walk_recursive($this->handlers, static function ($handler) use (&$myCommands): void {
            if ($handler instanceof InternalCommand && !$handler->isHidden() && !$handler->isDisabled()) {
                // scopes
                foreach ($handler->scopes() as $scope) {
                    $hashCode = crc32(serialize(get_object_vars($scope)));

                    // language_code
                    foreach ($handler->getDescription() as $language => $description) {
                        $myCommands[$hashCode]['scopes'][$language] = $scope;
                        $myCommands[$hashCode]['commands'][$language][] = $handler->toBotCommand($language);
                    }
                }
            }
        });

        $recap = [];

        // set commands for each scope
        foreach ($myCommands as $myCommand) {
            // set commands for each language
            foreach ($myCommand['scopes'] as $language => $scope) {
                /** @var BaseType&BotCommandScope $scope */

                /** @var BotCommand[] $commands */
                $commands = array_values(array_unique($myCommand['commands'][$language], SORT_REGULAR));
                $language_code = $language === '*' ? null : $language;

                $this->setMyCommands(
                    commands: $commands,
                    scope: $scope,
                    language_code: $language_code,
                );

                foreach ($commands as $command) {
                    $recap[] = new RegisteredCommand(
                        command: $command,
                        language: $language_code,
                        scope: $scope,
                    );
                }
            }
        }

        return $recap;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getBulkMessenger(): BulkMessenger
    {
        return $this->container->get(BulkMessenger::class);
    }

    public function invoke(callable|array|string $callable, array $params = []): mixed
    {
        return $this->container->call($callable, $params);
    }

    /**
     * Validate the token
     */
    protected function validateToken(string $token): void
    {
        if (empty($token)) {
            throw new InvalidArgumentException('The token cannot be empty.');
        }

        if (!preg_match("/\d+:.+/", $token)) {
            throw new InvalidArgumentException('The token is invalid.');
        }
    }
}
