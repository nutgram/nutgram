<?php


namespace SergiX44\Nutgram;

use DI\Container;
use GuzzleHttp\Client as Guzzle;
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
        $this->container->set(RunningMode::class, $this->container->make($config['running_mode'] ?? Polling::class));
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
}
