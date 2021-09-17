<?php


namespace SergiX44\Nutgram;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use JsonMapper;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
use SergiX44\Nutgram\Cache\ConversationCache;
use SergiX44\Nutgram\Cache\GlobalCache;
use SergiX44\Nutgram\Cache\UserCache;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\Proxies\GlobalCacheProxy;
use SergiX44\Nutgram\Proxies\UpdateDataProxy;
use SergiX44\Nutgram\Proxies\UserCacheProxy;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Update;
use Throwable;

class Nutgram extends ResolveHandlers
{
    use Client, UpdateDataProxy, GlobalCacheProxy, UserCacheProxy;

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
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Nutgram constructor.
     * @param  string  $token
     * @param  array  $config
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(string $token, array $config = [])
    {
        $this->token = $token;
        $this->config = $config;
        $this->container = new Container();

        $baseUri = $config['api_url'] ?? 'https://api.telegram.org';

        $this->http = new Guzzle(array_merge($config['client'] ?? [], [
            'base_uri' => "$baseUri/bot$token/",
            'timeout' => $config['timeout'] ?? 5,
        ]));

        $this->mapper = new JsonMapper();

        $this->container->set(Guzzle::class, $this->http);
        $this->container->set(JsonMapper::class, $this->mapper);
        $this->container->set(CacheInterface::class, $config['cache'] ?? new ArrayCache());

        $this->setRunningMode(Polling::class);
        $this->conversationCache = $this->container->get(ConversationCache::class);
        $this->globalCache = $this->container->get(GlobalCache::class);
        $this->userCache = $this->container->get(UserCache::class);

        $this->container->set(__CLASS__, $this);
    }

    /**
     * @param  string|RunningMode  $classOrInstance
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function setRunningMode(string|RunningMode $classOrInstance): void
    {
        if ($classOrInstance instanceof RunningMode) {
            $this->container->set(RunningMode::class, $classOrInstance);
        } else {
            $this->container->set(RunningMode::class, $this->container->get($classOrInstance));
        }
    }

    /**
     * @param  CacheInterface  $cache
     */
    public function setCache(CacheInterface $cache): void
    {
        $this->container->set(CacheInterface::class, $cache);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        $this->applyGlobalMiddlewares();
        $this->container->get(RunningMode::class)->processUpdates($this);
    }

    /**
     * @param  Update  $update
     * @throws Throwable
     * @throws DependencyException
     * @throws NotFoundException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdate(Update $update): void
    {
        $this->update = $update;

        $chatId = $this->chatId();
        $userId = $this->userId();

        $conversation = null;
        if ($chatId !== null && $userId !== null) {
            $conversation = $this->conversationCache->get($userId, $chatId);
        }

        if ($conversation !== null) {
            $handlers = $this->continueConversation($conversation);
        } else {
            $handlers = $this->resolveHandlers();
        }

        if (empty($handlers) && !empty($this->handlers[static::FALLBACK])) {
            $this->addHandlersBy($handlers, static::FALLBACK, value: $this->update->getType());
        }

        if (empty($handlers)) {
            $this->addHandlersBy($handlers, static::FALLBACK);
        }

        $this->fireHandlers($handlers);
    }

    /**
     * @param  array  $handlers
     * @throws Throwable
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function fireHandlers(array $handlers): void
    {
        try {
            /** @var Handler $handler */
            foreach ($handlers as $handler) {
                $handler->getHead()($this);
            }
        } catch (Throwable $e) {
            if ($this->onException !== null) {
                $handler = $this->onException;
                $handler->setParameters([$e]);
                $handler($this);
            } else {
                throw $e;
            }
        }
    }

    /**
     * @param  Handler  $handler
     * @param  Throwable  $e
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function fireApiErrorHandler(Handler $handler, Throwable $e): mixed
    {
        $handler->setParameters([$e]);
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
        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot set a conversation step without processing and update.');
        }

        $this->conversationCache->set(
            $userId ?? $this->userId(),
            $chatId ?? $this->chatId(),
            $callable
        );

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
        if ($this->update === null && ($userId === null || $chatId === null)) {
            throw new InvalidArgumentException('You cannot set a conversation step without processing and update.');
        }

        $this->conversationCache->delete(
            $userId ?? $this->userId(),
            $chatId ?? $this->chatId(),
        );

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
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function getUpdateMode(): string
    {
        return get_class($this->container->get(RunningMode::class));
    }

    /**
     * @param $callable
     * @return callable|mixed
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function resolve($callable)
    {
        // if is a class definition, resolve it to an instance through the container
        if (is_array($callable) && count($callable) === 2 && is_string($callable[0]) && class_exists($callable[0])) {
            $callable[0] = $this->container->make($callable[0]);
        }

        // if passing a class, we probably want resolve that and call the __invoke method
        if (is_string($callable) && class_exists($callable)) {
            $callable = $this->container->make($callable);
        }

        if (!is_callable($callable)) {
            throw new InvalidArgumentException('The callback parameter must be a valid callable.');
        }

        return $callable;
    }
}
