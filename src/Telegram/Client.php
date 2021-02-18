<?php


namespace SergiX44\Nutgram\Telegram;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Endpoints\AvailableMethods;
use SergiX44\Nutgram\Telegram\Endpoints\Games;
use SergiX44\Nutgram\Telegram\Endpoints\InlineMode;
use SergiX44\Nutgram\Telegram\Endpoints\Passport;
use SergiX44\Nutgram\Telegram\Endpoints\Payments;
use SergiX44\Nutgram\Telegram\Endpoints\Stickers;
use SergiX44\Nutgram\Telegram\Endpoints\UpdatesMessages;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Update;
use SergiX44\Nutgram\Telegram\Types\WebhookInfo;
use stdClass;

/**
 * Trait Client
 * @package SergiX44\Nutgram\Telegram
 * @mixin Nutgram
 */
trait Client
{
    use AvailableMethods,
        UpdatesMessages,
        Stickers,
        InlineMode,
        Payments,
        Passport,
        Games;

    /**
     * @param  array  $parameters
     * @return mixed
     */
    public function getUpdates(array $parameters = [])
    {
        return $this->requestJson(__FUNCTION__, $parameters, Update::class, [
            'timeout' => $parameters['timeout'] + 1,
        ]);
    }

    /**
     * @param  string  $url
     * @param  array|null  $opt
     * @return mixed
     */
    public function setWebhook(string $url, ?array $opt = []): bool
    {
        $required = compact('url');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  array|null  $opt
     * @return bool
     */
    public function deleteWebhook(?array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, $opt);
    }

    /**
     * @return WebhookInfo
     */
    public function getWebhookInfo(): WebhookInfo
    {
        return $this->requestJson(__FUNCTION__, mapTo: WebhookInfo::class);
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $parameters
     * @param  array|null  $options
     * @return mixed
     */
    public function sendRequest(string $endpoint, ?array $parameters = [], ?array $options = []): mixed
    {
        return $this->http->postAsync($endpoint, array_merge(['multipart' => $parameters], $options))
            ->then(function (ResponseInterface $response) {
                $body = $response->getBody()->getContents();
                return json_decode($body);
            })->wait();
    }

    /**
     * @param  string  $param
     * @param $value
     * @param  array  $opt
     * @return mixed
     */
    protected function sendAttachment(string $param, $value, array $opt = []): Message
    {
        $required = [
            'chat_id' => $this->chatId(),
            $param => $value,
        ];
        if (is_resource($value)) {
            return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), Message::class);
        } else {
            return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
        }
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $multipart
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     */
    protected function requestMultipart(string $endpoint, ?array $multipart = null, string $mapTo = stdClass::class, ?array $options = []): mixed
    {
        $parameters = [];
        foreach ($multipart as $name => $contents) {
            $parameters[] = [
                'name' => $name,
                'contents' => $contents,
            ];
        }
        $promise = $this->http->postAsync($endpoint, array_merge(['multipart' => $parameters], $options));
        return $this->mapResponse($promise, $mapTo);
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $json
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     */
    protected function requestJson(string $endpoint, ?array $json = null, string $mapTo = stdClass::class, ?array $options = []): mixed
    {
        $promise = $this->http->postAsync($endpoint, array_merge([
            'json' => $json,
        ], $options));

        return $this->mapResponse($promise, $mapTo);
    }

    /**
     * @param  PromiseInterface  $promise
     * @param  string  $mapTo
     * @return mixed
     */
    private function mapResponse(PromiseInterface $promise, string $mapTo): mixed
    {
        return $promise->then(function (ResponseInterface $response) use ($mapTo) {
            $body = $response->getBody()->getContents();
            $json = json_decode($body);

            return match (true) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => $this->mapper->mapArray($json->result, [], $mapTo),
                default => $this->mapper->map($json->result, new $mapTo)
            };
        }, function ($e) {
            if ($e instanceof RequestException) {
                $body = $e->getResponse()->getBody()->getContents();
                $json = json_decode($body);

                $e = new TelegramException($json->description, $json->error_code);
            }

            if ($this->onApiError !== null) {
                return $this->fireApiErrorHandler($e);
            }

            throw $e;
        })->wait();
    }
}
