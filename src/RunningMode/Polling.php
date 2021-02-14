<?php


namespace SergiX44\Nutgram\RunningMode;

use GuzzleHttp\Client as Guzzle;
use JsonMapper;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Update;

class Polling implements RunningMode
{
    use Client;

    /**
     * @var JsonMapper
     */
    private JsonMapper $mapper;

    /**
     * @var Guzzle
     */
    private Guzzle $http;

    /**
     * Polling constructor.
     * @param  JsonMapper  $mapper
     * @param  Guzzle  $http
     */
    public function __construct(JsonMapper $mapper, Guzzle $http)
    {
        $this->mapper = $mapper;
        $this->http = $http;
    }

    public function processUpdates(Nutgram $bot)
    {
        $pollingConfig = $bot->getConfig()['polling'] ?? [];
        $timeout = $pollingConfig['timeout'] ?? $bot->getConfig()['client_timeout'] ?? 10;
        $allowedUpdates = isset($pollingConfig['allowed_updates']) ? ['allowed_updates' => $pollingConfig['allowed_updates']] : [];


        $parameters = array_merge([
            'limit' => $pollingConfig['limit'] ?? 100,
            'timeout' => $timeout,
        ], $allowedUpdates);

        $offset = 1;
        while (true) {
            $updates = $this->getUpdates(array_merge(['offset' => $offset], $parameters));

            if ($offset === 1) {
                /** @var Update $last */
                $last = end($updates);
                if ($last) {
                    $offset = $last->update_id;
                }

                continue;
            }

            /** @var Update $update */
            foreach ($updates as $update) {
                $offset++;
                $bot->processUpdate($update);
                $bot->clearData();
            }

            gc_collect_cycles();
        }
    }
}
