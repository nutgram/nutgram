<?php


namespace SergiX44\Nutgram\Telegram;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;
use stdClass;

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
        $chat_id = $this->getChatId();
        return $this->request(__FUNCTION__, compact($text, $chat_id, $opt), Message::class);
    }

    /**
     * @param  array  $parameters
     * @return mixed
     */
    public function getUpdates(array $parameters = [])
    {
        return $this->request(__FUNCTION__, $parameters, Update::class, [
            'timeout' => $parameters['timeout'] + 1,
        ]);
    }

    /**
     * @param  string  $method
     * @param  array|null  $parameters
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     */
    protected function request(string $method, ?array $parameters = [], string $mapTo = stdClass::class, ?array $options = [])
    {
        $promise = $this->http->postAsync($method, array_merge([
            'json' => $parameters,
        ], $options))->then(function (ResponseInterface $response) use ($mapTo) {
            $body = $response->getBody()->getContents();
            $json = json_decode($body);

            return match ($json->result) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => $this->mapper->mapArray($json->result, [], $mapTo),
                default => $this->mapper->map($json->result, new $mapTo)
            };
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
