<?php


namespace SergiX44\Nutgram;

use DI\Container;
use GuzzleHttp\Client as Guzzle;
use InvalidArgumentException;
use JsonMapper;
use SergiX44\Nutgram\Handlers\ResolveHandlers;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Client;

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
        $runningMode = $config['running_mode'] ?? Polling::class;
        if (is_object($runningMode)) {
            $this->container->set(RunningMode::class, $runningMode);
        } else {
            $this->container->set(RunningMode::class, $this->container->get($runningMode));
        }
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function run()
    {
        $this->container->get(RunningMode::class)->processUpdates($this);
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
