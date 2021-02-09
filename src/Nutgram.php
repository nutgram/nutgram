<?php


namespace SergiX44\Nutgram;

use GuzzleHttp\Client as Guzzle;
use JsonMapper;
use SergiX44\Nutgram\Telegram\Client;

class Nutgram
{
    use Client;

    /**
     * @var string
     */
    private string $token;

    /**
     * @var array|null
     */
    private ?array $config;

    /**
     * @var Guzzle
     */
    private Guzzle $http;

    /**
     * @var JsonMapper
     */
    private JsonMapper $jsonMapper;

    /**
     * Nutgram constructor.
     * @param  string  $token
     * @param  array|null  $config
     */
    public function __construct(string $token, ?array $config = [])
    {
        $this->token = $token;
        $this->config = $config;

        $baseUri = $config['api_url'] ?? 'https://api.telegram.org';

        $this->http = new Guzzle([
            'base_uri' => "{$baseUri}/bot{$token}/",
            'timeout' => $config['client_timeout'] ?? 5,
        ]);

        $this->jsonMapper = new JsonMapper();
    }
}
