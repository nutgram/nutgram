<?php


namespace SergiX44\Nutgram;

use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use Laravel\SerializableClosure\SerializableClosure;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Proxies\GlobalCacheProxy;
use SergiX44\Nutgram\Proxies\UpdateDataProxy;
use SergiX44\Nutgram\Proxies\UserCacheProxy;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Support\BulkMessenger;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Testing\FakeNutgram;
use Throwable;

class Nutgram extends ResolveHandlers
{
    use Client, UpdateDataProxy, GlobalCacheProxy, UserCacheProxy;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var Configuration
     */
    private Configuration $config;

    /**
     * @var ClientInterface
     */
    private ClientInterface $http;

    /**
     * @var Hydrator
     */
    protected Hydrator $hydrator;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Nutgram constructor.
     * @param  string  $token
     * @param  Configuration|null  $config
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(string $token, ?Configuration $config = null)
    {
        if (empty($token)) {
            throw new InvalidArgumentException('The token cannot be empty.');
        }

        $this->bootstrap($token, $config ?? new Configuration());
    }

    /**
     * Initializes the current instance
     * @param  string  $token
     * @param  Configuration  $config
     * @return void
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
        $this->container->delegate(new ReflectionContainer());
        $this->container->addShared(ContainerInterface::class, $this->container);

        SerializableClosure::setSecretKey($this->token);

        $baseUri = sprintf(
            '%s/bot%s/%s',
            $config->apiUrl,
            $this->token,
            $config->testEnv ?? false ? 'test/' : ''
        );

        $this->http = new Guzzle([
            'base_uri' => $baseUri,
            'timeout' => $config->clientTimeout,
            ...$config->clientOptions,
        ]);

        $this->container->addShared(ClientInterface::class, $this->http);

        $hydrator = $this->container->get($config->hydrator);
        $this->container->addShared(Hydrator::class)->setConcrete($hydrator);
        $this->hydrator = $this->container->get(Hydrator::class);

        $botId = $config->botId ?? (int)explode(':', $this->token)[0];
        $this->container->addShared(CacheInterface::class, $config->cache);
        $this->container->addShared(LoggerInterface::class, $config->logger);

        $this->container->add(ConversationCache::class)->addArguments([CacheInterface::class, $botId]);
        $this->container->add(GlobalCache::class)->addArguments([CacheInterface::class, $botId]);
        $this->container->add(UserCache::class)->addArguments([CacheInterface::class, $botId]);

        $this->conversationCache = $this->container->get(ConversationCache::class);
        $this->globalCache = $this->container->get(GlobalCache::class);
        $this->userCache = $this->container->get(UserCache::class);
        $this->logger = $this->container->get(LoggerInterface::class);

        $this->container->addShared(RunningMode::class, Polling::class);
        $this->container->addShared(__CLASS__, $this);
    }

    /**
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'token' => $this->token,
            'config' => $this->config,
        ];
    }

    /**
     * @param  array  $data
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __unserialize(array $data): void
    {
        $this->bootstrap($data['token'], $data['config']);
    }

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return FakeNutgram
     */
    public static function fake(mixed $update = null, array $responses = [], ?Configuration $config = null): FakeNutgram
    {
        return FakeNutgram::instance($update, $responses, $config);
    }

    /**
     * @param  string|RunningMode  $classOrInstance
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setRunningMode(string|RunningMode $classOrInstance): void
    {
        $this->container->extend(RunningMode::class)->setConcrete($classOrInstance);
    }

    /**
     * @param  CacheInterface  $cache
     */
    public function setCache(CacheInterface $cache): void
    {
        $this->container->extend(CacheInterface::class)->setConcrete($cache);
        $this->conversationCache = $this->container->get(ConversationCache::class);
        $this->globalCache = $this->container->get(GlobalCache::class);
        $this->userCache = $this->container->get(UserCache::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        if (!$this->finalized) {
            $this->resolveGroups();
            $this->applyGlobalMiddleware();
            $this->finalized = true;
        }
        $this->container->get(RunningMode::class)->processUpdates($this);
    }

    /**
     * @param  Update  $update
     * @throws Throwable
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdate(Update $update): void
    {
        $this->update = $update;

        $conversation = $this->currentConversation($this->userId(), $this->chatId());

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

    /**
     * @param  string  $type
     * @param  array  $parameters
     * @return mixed
     * @throws Throwable
     */
    protected function fireHandlersBy(string $type, array $parameters = []): mixed
    {
        $handlers = [];
        $this->addHandlersBy($handlers, $type);
        return $this->fireHandlers($handlers, $parameters);
    }

    /**
     * @param  array  $handlers
     * @param  array  $parameters
     * @return mixed
     * @throws Throwable
     */
    protected function fireHandlers(array $handlers, array $parameters = []): mixed
    {
        $result = null;

        /** @var Handler $handler */
        foreach ($handlers as $handler) {
            try {
                $result = $handler->addParameters($parameters)->getHead()($this);
            } catch (Throwable $e) {
                if (!empty($this->handlers[self::EXCEPTION])) {
                    $this->fireExceptionHandlerBy(self::EXCEPTION, $e);
                    continue;
                }

                throw $e;
            }
        }

        return $result;
    }

    /**
     * @param  string  $type
     * @param  Throwable  $e
     * @return mixed
     */
    protected function fireExceptionHandlerBy(string $type, Throwable $e): mixed
    {
        $handlers = [];

        if ($e instanceof TelegramException) {
            $this->addHandlersBy($handlers, $type, value: $e->getMessage());
        } else {
            $this->addHandlersBy($handlers, $type, $e::class);
        }


        if (empty($handlers)) {
            $this->addHandlersBy($handlers, $type);
        }

        /** @var Handler $handler */
        $handler = reset($handlers)->setParameters($e);
        return $handler($this);
    }

    /**
     * @param  Conversations\Conversation|callable  $callable
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function stepConversation(
        Conversations\Conversation|callable $callable,
        ?int $userId = null,
        ?int $chatId = null
    ): self {
        $userId = $userId ?? $this->userId();
        $chatId = $chatId ?? $this->chatId();

        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot step a conversation without userId and chatId.');
        }

        $this->conversationCache->set($userId, $chatId, $callable);

        return $this;
    }

    /**
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function endConversation(?int $userId = null, ?int $chatId = null): self
    {
        $userId = $userId ?? $this->userId();
        $chatId = $chatId ?? $this->chatId();

        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot end a conversation without userId and chatId.');
        }

        $this->conversationCache->delete($userId, $chatId);

        return $this;
    }

    /**
     * @return ContainerInterface|Container
     */
    public function getContainer(): ContainerInterface|Container
    {
        return $this->container;
    }

    /**
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUpdateMode(): string
    {
        return $this->container->get(RunningMode::class)::class;
    }

    /**
     * @param  callable|array|string  $callable
     * @return callable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve(callable|array|string $callable): callable
    {
        // if is a class definition, resolve it to an instance through the container
        if (is_array($callable) && count($callable) === 2 && is_string($callable[0]) && class_exists($callable[0])) {
            $callable[0] = $this->container->get($callable[0]);
        }

        // if passing a class, we probably want resolve that and call the __invoke method
        if (is_string($callable) && class_exists($callable)) {
            $callable = $this->container->get($callable);
        }

        if (!is_callable($callable)) {
            throw new InvalidArgumentException('The callback parameter must be a valid callable.');
        }

        return $callable;
    }

    /**
     * Set my commands call to Telegram using all the registered commands
     */
    public function registerMyCommands(): void
    {
        /** @var BotCommandScope[] $commands */
        $scopes = [];
        /** @var Command[] $commands */
        $commands = [];
        array_walk_recursive($this->handlers, static function ($handler) use (&$commands, &$scopes) {
            if ($handler instanceof Command && !$handler->isHidden()) {
                foreach ($handler->scopes() as $scope) {
                    $hashCode = crc32(serialize(get_object_vars($scope)));
                    $scopes[$hashCode] = $scope;
                    $commands[$hashCode][] = $handler->toBotCommand();
                }
            }
        });

        // set commands for each scope
        foreach ($scopes as $hashCode => $scope) {
            $this->setMyCommands(
                commands: array_unique($commands[$hashCode], SORT_REGULAR),
                scope: $scope,
            );
        }
    }

    /**
     * @return BulkMessenger
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getBulkMessenger(): BulkMessenger
    {
        return $this->container->get(BulkMessenger::class);
    }

    /**
     * Returns a list of all parameters parsed by the current handlers
     *
     * @return array
     */
    public function currentParameters(): array
    {
        return $this->currentParameters;
    }
}
