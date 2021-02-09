<?php


namespace SergiX44\Nutgram;

use DI\Container;
use GuzzleHttp\Client as Guzzle;
use JsonMapper;
use SergiX44\Nutgram\RunningMode\RunningMode;
use SergiX44\Nutgram\Telegram\Client;

class Nutgram
{
    use Client;
    use ProcessUpdates;

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
    private JsonMapper $jsonMapper;

    /**
     * @var Container
     */
    private Container $container;

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

        $this->jsonMapper = new JsonMapper();

        $this->container->set('config', $this->config);
        $this->container->set(Guzzle::class, $this->http);
        $this->container->set(JsonMapper::class, $this->jsonMapper);
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
}
