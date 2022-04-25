<?php


namespace SergiX44\Nutgram;

use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Hydrator\NutgramHydrator;
use SergiX44\Nutgram\Proxies\GlobalCacheProxy;
use SergiX44\Nutgram\Proxies\UpdateDataProxy;
use SergiX44\Nutgram\Proxies\UserCacheProxy;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Testing\FakeNutgram;
use Throwable;

class Nutgram extends ResolveHandlers
{
    use Client, UpdateDataProxy, GlobalCacheProxy, UserCacheProxy;

    protected const DEFAULT_API_URL = 'https://api.telegram.org';

    /**
     * @var string
     */
    private string $token;

    /**
     * @var array
     */
    private array $config;

    /**
     * @var ClientInterface
     */
    private ClientInterface $http;

    /**
     * @var Hydrator
     */
    private Hydrator $mapper;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var bool
     */
    private bool $middlewareApplied = false;

    /**
     * Nutgram constructor.
     * @param  string  $token
     * @param  array  $config
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(string $token, array $config = [])
    {
        if (empty($token)) {
            throw new InvalidArgumentException('The token cannot be empty.');
        }

        $this->token = $token;
        $this->config = $config;
        $this->container = new Container();
        $this->container->delegate(new ReflectionContainer());

        $baseUri = $config['api_url'] ?? self::DEFAULT_API_URL;

        $this->http = new Guzzle(array_merge([
            'base_uri' => "$baseUri/bot$token/",
            'timeout' => $config['timeout'] ?? 5,
        ], $config['client'] ?? []));
        $this->container->addShared(ClientInterface::class, $this->http);

        $this->container->addShared(Hydrator::class)->setConcrete($config['mapper'] ?? NutgramHydrator::class);
        $this->mapper = $this->container->get(Hydrator::class);

        $this->container->addShared(CacheInterface::class, $config['cache'] ?? new ArrayCache());
        $this->conversationCache = $this->container->get(ConversationCache::class);
        $this->globalCache = $this->container->get(GlobalCache::class);
        $this->userCache = $this->container->get(UserCache::class);

        $this->container->addShared(RunningMode::class, Polling::class);
        $this->container->addShared(__CLASS__, $this);
    }

    /**
     * @param  mixed  $update
     * @param  array  $responses
     * @return FakeNutgram
     */
    public static function fake(mixed $update = null, array $responses = []): FakeNutgram
    {
        return FakeNutgram::instance($update, $responses);
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
        $this->container->extend(CacheInterface::class)
            ->setConcrete($cache);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        if (!$this->middlewareApplied) {
            $this->applyGlobalMiddleware();
            $this->middlewareApplied = true;
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

        $conversation = $this->getConversation($this->userId(), $this->chatId());

        if ($conversation !== null) {
            $handlers = $this->continueConversation($conversation);
        } else {
            $handlers = $this->resolveHandlers();
        }

        if (empty($handlers) && !empty($this->handlers[self::FALLBACK])) {
            $this->addHandlersBy($handlers, self::FALLBACK, value: $this->update->getType());
        }

        if (empty($handlers)) {
            $this->addHandlersBy($handlers, self::FALLBACK);
        }

        $this->fireHandlers($handlers);
    }

    /**
     * @param  array  $handlers
     * @throws Throwable
     */
    protected function fireHandlers(array $handlers): void
    {
        /** @var Handler $handler */
        foreach ($handlers as $handler) {
            try {
                $handler->getHead()($this);
            } catch (Throwable $e) {
                if (!empty($this->handlers[self::EXCEPTION])) {
                    $this->fireExceptionHandlerBy(self::EXCEPTION, $e);
                    continue;
                }

                throw $e;
            }
        }
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
     * @param  $callable
     * @param  int|null  $userId
     * @param  int|null  $chatId
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function stepConversation($callable, ?int $userId = null, ?int $chatId = null): self
    {
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
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function getConfig(): array
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
     * @param $callable
     * @return callable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve($callable): callable
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
    public function registerMyCommands(?array $opt = []): bool|null
    {
        $commands = [];
        array_walk_recursive($this->handlers, static function ($handler) use (&$commands) {
            if ($handler instanceof Command && !$handler->isHidden()) {
                $commands[] = $handler->toBotCommand();
            }
        });

        return $this->setMyCommands($commands, $opt);
    }
}
