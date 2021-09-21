<?php


namespace SergiX44\Nutgram\Telegram;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use JsonMapper_Exception;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Endpoints\AvailableMethods;
use SergiX44\Nutgram\Telegram\Endpoints\Games;
use SergiX44\Nutgram\Telegram\Endpoints\InlineMode;
use SergiX44\Nutgram\Telegram\Endpoints\Passport;
use SergiX44\Nutgram\Telegram\Endpoints\Payments;
use SergiX44\Nutgram\Telegram\Endpoints\Stickers;
use SergiX44\Nutgram\Telegram\Endpoints\UpdatesMessages;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\File;
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
    public function getUpdates(array $parameters = []): mixed
    {
        return $this->requestJson(__FUNCTION__, $parameters, Update::class, [
            'timeout' => ($parameters['timeout'] ?? 0) + 1,
        ]);
    }

    /**
     * @param  string  $url
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setWebhook(string $url, ?array $opt = []): ?bool
    {
        $required = compact('url');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  array|null  $opt
     * @return bool|null
     */
    public function deleteWebhook(?array $opt = []): ?bool
    {
        return $this->requestJson(__FUNCTION__, $opt);
    }

    /**
     * @return WebhookInfo|null
     */
    public function getWebhookInfo(): ?WebhookInfo
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
        return $this->requestMultipart($endpoint, $parameters, options: $options);
    }

    /**
     * @param  string  $endpoint
     * @param  string  $param
     * @param $value
     * @param  array  $opt
     * @return Message|null
     */
    protected function sendAttachment(string $endpoint, string $param, $value, array $opt = []): ?Message
    {
        $required = [
            'chat_id' => $this->chatId(),
            $param => $value,
        ];
        if (is_resource($value)) {
            return $this->requestMultipart($endpoint, array_merge($required, $opt), Message::class);
        }

        return $this->requestJson($endpoint, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  File  $file
     * @param  string  $path
     * @return bool|null
     */
    public function downloadFile(File $file, string $path): ?bool
    {
        $baseUri = $config['api_url'] ?? 'https://api.telegram.org';

        if (!is_dir(dirname($path)) && !mkdir($concurrentDirectory = dirname($path), true, true) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Error creating directory "%s"', $concurrentDirectory));
        }

        return copy("$baseUri/file/bot$this->token/$file->file_path", $path);
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $multipart
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     */
    protected function requestMultipart(
        string $endpoint,
        ?array $multipart = null,
        string $mapTo = stdClass::class,
        ?array $options = []
    ): mixed {
        $parameters = [];
        foreach ($multipart as $name => $contents) {
            $parameters[] = [
                'name' => $name,
                'contents' => $contents,
            ];
        }

        try {
            $response = $this->http->post($endpoint, array_merge(['multipart' => $parameters], $options));
            return $this->mapResponse($response, $mapTo);
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            $response = $exception->getResponse();
            return $this->mapResponse($response, $mapTo, $exception);
        }
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $json
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     */
    protected function requestJson(
        string $endpoint,
        ?array $json = null,
        string $mapTo = stdClass::class,
        ?array $options = []
    ): mixed {
        try {
            $response = $this->http->post($endpoint, array_merge([
                'json' => $json,
            ], $options));
            return $this->mapResponse($response, $mapTo);
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            $response = $exception->getResponse();
            return $this->mapResponse($response, $mapTo, $exception);
        }
    }

    /**
     * @param  ResponseInterface  $response
     * @param  string  $mapTo
     * @param  Exception|null  $clientException
     * @return mixed
     * @throws TelegramException
     * @throws DependencyException
     * @throws NotFoundException
     * @throws JsonMapper_Exception
     */
    private function mapResponse(ResponseInterface $response, string $mapTo, Exception $clientException = null): mixed
    {
        $json = json_decode((string) $response->getBody(), flags: JSON_THROW_ON_ERROR);
        if ($json?->ok) {
            $instance = $this->container->make($mapTo);
            return match (true) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => array_map(fn ($obj) => $this->mapper->map($obj, $instance), $json->result),
                default => $this->mapper->map($json->result, $instance)
            };
        }

        $e = new TelegramException($json?->description ?? '', $json?->error_code ?? 0, $clientException);

        if ($this->onApiError !== null) {
            return $this->fireApiErrorHandler($this->onApiError, $e);
        }

        throw $e;
    }
}
