<?php


namespace SergiX44\Nutgram;

use DI\Container;
use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use JsonMapper;
use Psr\SimpleCache\CacheInterface;
use SergiX44\Nutgram\Cache\ArrayCache;
use SergiX44\Nutgram\Conversation\ConversationRepository;
use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Update;
use Throwable;

class Nutgram extends ResolveHandlers
{
    use Client;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var array
     */
    private array $config;

    /**
     * @var Guzzle
     */
    private Guzzle $http;

    /**
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * Nutgram constructor.
     * @param  string  $token
     * @param  array  $config
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(string $token, array $config = [])
    {
        $this->token = $token;
        $this->config = $config;
        $this->container = new Container();

        $baseUri = $config['api_url'] ?? 'https://api.telegram.org';

        $this->http = new Guzzle([
            'base_uri' => "{$baseUri}/bot{$token}/",
            'timeout' => $config['client_timeout'] ?? 5,
        ]);

        $this->mapper = new JsonMapper();

        $this->container->set(Guzzle::class, $this->http);
        $this->container->set(JsonMapper::class, $this->mapper);
        $this->container->set(CacheInterface::class, $config['cache'] ?? new ArrayCache());

        $this->setRunningMode(Polling::class);
        $this->conversation = $this->container->get(ConversationRepository::class);
    }

    /**
     * @param  string|RunningMode  $classOrInstance
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function setRunningMode($classOrInstance): void
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
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function run()
    {
        $this->applyGlobalMiddlewares();
        $this->container->get(RunningMode::class)->processUpdates($this);
    }

    /**
     * @param  Update  $update
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdate(Update $update): void
    {
        $this->update = $update;
        $this->container->set(Update::class, $update);

        $chatId = $update->getChatId();
        $userId = $update->getUser()->id;

        $conversation = $this->conversation->get($userId, $chatId);
        if ($conversation !== null) {
            $conversation->setBot($this);
            $handlers = $this->continueConversation($conversation);
        } else {
            $handlers = $this->resolveHandlers();
        }

        $this->fireHandlers($handlers);
    }

    /**
     * @param  array  $handlers
     */
    protected function fireHandlers(array $handlers)
    {
        try {
            /** @var Handler $handler */
            foreach ($handlers as $handler) {
                $handler->getHead()($this);
            }
        } catch (Throwable $e) {
            //TODO
            throw $e;
        }
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
     * @param $callable
     * @return callable|mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
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
