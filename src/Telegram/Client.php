<?php


namespace SergiX44\Nutgram\Telegram;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Message;

/**
 * Trait Client
 * @package SergiX44\Nutgram\Telegram
 * @mixin Nutgram
 */
trait Client
{
    /**
     * @param  string  $text
     * @param  array|null  $opt
     * @return Message
     */
    public function sendMessage(string $text, ?array $opt = []): Message
    {
        return $this->request(__FUNCTION__, Message::class, array_merge([
            'text' => $text,
        ], $opt));
    }

    /**
     * @param  string  $method
     * @param  string  $mapTo
     * @param  array|null  $parameters
     * @return mixed
     */
    protected function request(string $method, string $mapTo = 'Scalar', ?array $parameters = [])
    {
        $promise = $this->http->postAsync($method, [
            'json' => $parameters,
        ])->then(function (ResponseInterface $response) use ($mapTo) {
            $body = $response->getBody()->getContents();
            $json = json_decode($body);

            if (is_scalar($json->result) && $mapTo === 'Scalar') {
                return $json->result;
            }

            return $this->jsonMapper->map($json->result, new $mapTo);
        }, function ($e) {
            if ($e instanceof RequestException) {
                $body = $e->getResponse()->getBody()->getContents();
                $json = json_decode($body);

                throw new TelegramException($json->description, $json->error_code);
            }

            throw $e;
        });

        return $promise->wait();
    }
}
