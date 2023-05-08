<?php


namespace SergiX44\Nutgram\Telegram;

use BackedEnum;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Traits\Macroable;
use JsonException;
use JsonSerializable;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\StrUtils;
use SergiX44\Nutgram\Telegram\Endpoints\AvailableMethods;
use SergiX44\Nutgram\Telegram\Endpoints\CustomEndpoints;
use SergiX44\Nutgram\Telegram\Endpoints\Games;
use SergiX44\Nutgram\Telegram\Endpoints\InlineMode;
use SergiX44\Nutgram\Telegram\Endpoints\Passport;
use SergiX44\Nutgram\Telegram\Endpoints\Payments;
use SergiX44\Nutgram\Telegram\Endpoints\Stickers;
use SergiX44\Nutgram\Telegram\Endpoints\UpdatesMessages;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
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
        Games,
        CustomEndpoints,
        Macroable;

    /**
     * Use this method to receive incoming updates using long polling.
     * An Array of Update objects is returned.
     * @see https://core.telegram.org/bots/api#getupdates
     * @see https://en.wikipedia.org/wiki/Push_technology#Long_polling
     * @param int|null $offset
     * @param int|null $limit
     * @param int|null $timeout
     * @param string[]|null $allowed_updates
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function getUpdates(?int $offset = null, ?int $limit = null, ?int $timeout = null, ?array $allowed_updates = null): ?array
    {
        $timeout = ($timeout ?? $this->config->pollingTimeout) + 1;

        return $this->requestJson(__FUNCTION__, compact(
            'offset',
            'limit',
            'timeout',
            'allowed_updates'
        ), Update::class);
    }

    /**
     * @param string $url
     * @param InputFile|null $certificate
     * @param string|null $ip_address
     * @param int|null $max_connections
     * @param string[]|null $allowed_updates
     * @param bool|null $drop_pending_updates
     * @param string|null $secret_token
     * @return bool|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function setWebhook(
        string $url,
        ?InputFile $certificate = null,
        ?string $ip_address = null,
        ?int $max_connections = null,
        ?array $allowed_updates = null,
        ?bool $drop_pending_updates = null,
        ?string $secret_token = null
    ): ?bool {
        return $this->requestJson(__FUNCTION__, compact(
            'url',
            'certificate',
            'ip_address',
            'max_connections',
            'allowed_updates',
            'drop_pending_updates',
            'secret_token'
        ));
    }

    /**
     * @param bool $drop_pending_updates
     * @return bool|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function deleteWebhook(?bool $drop_pending_updates = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('drop_pending_updates'));
    }

    /**
     * @return WebhookInfo|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function getWebhookInfo(): ?WebhookInfo
    {
        return $this->requestJson(__FUNCTION__, mapTo: WebhookInfo::class);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function sendRequest(string $endpoint, array $parameters = [], array $options = []): mixed
    {
        return $this->requestMultipart($endpoint, $parameters, options: $options);
    }

    /**
     * @param string $endpoint
     * @param string $param
     * @param mixed $value
     * @param array $opt
     * @param array $clientOpt
     * @return Message|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    protected function sendAttachment(
        string $endpoint,
        string $param,
        mixed $value,
        array $opt = [],
        array $clientOpt = []
    ): ?Message {
        $required = [
            'chat_id' => $this->chatId(),
            $param => $value,
        ];

        if (is_resource($value) || $value instanceof InputFile) {
            $required[$param] = $value instanceof InputFile ? $value : new InputFile($value);
            return $this->requestMultipart($endpoint, [...$required, ...$opt], Message::class, $clientOpt);
        }

        return $this->requestJson($endpoint, [...$required, ...$opt], Message::class);
    }

    /**
     * @param File $file
     * @param string $path
     * @param array $clientOpt
     * @return bool|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function downloadFile(File $file, string $path, array $clientOpt = []): ?bool
    {
        if (!is_dir(dirname($path)) && !mkdir(
            $concurrentDirectory = dirname($path),
            0775,
            true
        ) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Error creating directory "%s"', $concurrentDirectory));
        }

        if ($this->config->isLocal) {
            return copy($this->downloadUrl($file), $path);
        }

        $request = ['sink' => $path, ...$clientOpt];
        $endpoint = $this->downloadUrl($file);

        $requestPost = $this->fireHandlersBy(self::BEFORE_API_REQUEST, [$request]);
        try {
            $response = $this->http->get($endpoint, $requestPost ?? $request);
        } catch (ConnectException $e) {
            $this->redactTokenFromConnectException($e);
        }

        return $response->getStatusCode() === 200;
    }

    /**
     * @param File $file
     * @return string|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function downloadUrl(File $file): string|null
    {
        if ($this->config->isLocal) {
            if (isset($this->config->localPathTransformer)) {
                return call_user_func($this->resolve($this->config->localPathTransformer), $file->file_path);
            }

            return $file->file_path;
        }

        return "{$this->config->apiUrl}/file/bot$this->token/$file->file_path";
    }

    /**
     * @param string $endpoint
     * @param array $multipart
     * @param string $mapTo
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    protected function requestMultipart(
        string $endpoint,
        array $multipart = [],
        string $mapTo = stdClass::class,
        array $options = []
    ): mixed {
        $parameters = [];
        foreach (array_filter($multipart) as $name => $contents) {
            if ($contents instanceof InputMedia) {
                $parameters[] = [
                    'name' => $contents->media->getFilename(),
                    'contents' => $contents->media->getResource(),
                    'filename' => $contents->media->getFilename(),
                ];
            }

            $parameters[] = match (true) {
                $contents instanceof InputFile => [
                    'name' => $name,
                    'contents' => $contents->getResource(),
                    'filename' => $contents->getFilename(),
                ],
                $contents instanceof JsonSerializable => [
                    'name' => $name,
                    'contents' => json_encode($contents, JSON_THROW_ON_ERROR),
                ],
                $contents instanceof BackedEnum => [
                    'name' => $name,
                    'contents' => $contents->value,
                ],
                default => [
                    'name' => $name,
                    'contents' => $contents,
                ]
            };
        }

        $request = ['multipart' => $parameters, ...$options];

        try {
            $requestPost = $this->fireHandlersBy(self::BEFORE_API_REQUEST, [$request]);
            try {
                $response = $this->http->post($endpoint, $requestPost ?? $request);
            } catch (ConnectException $e) {
                $this->redactTokenFromConnectException($e);
            }
            $content = $this->mapResponse($response, $mapTo);

            $this->logger->debug($endpoint, [
                'content' => $content,
                'parameters' => $parameters,
                'options' => $options,
            ]);

            return $content;
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * @param string $endpoint
     * @param array $json
     * @param string $mapTo
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    protected function requestJson(
        string $endpoint,
        array $json = [],
        string $mapTo = stdClass::class,
        array $options = []
    ): mixed {
        $json = array_map(fn ($item) => match (true) {
            $item instanceof BackedEnum => $item->value,
            default => $item,
        }, array_filter($json));

        $request = ['json' => $json, ...$options];

        try {
            $requestPost = $this->fireHandlersBy(self::BEFORE_API_REQUEST, [$request]);
            try {
                $response = $this->http->post($endpoint, $requestPost ?? $request);
            } catch (ConnectException $e) {
                $this->redactTokenFromConnectException($e);
            }
            $content = $this->mapResponse($response, $mapTo);

            $rawResponse = (string)$response->getBody();
            $this->logger->debug($endpoint.PHP_EOL.$rawResponse, [
                'parameters' => $json,
                'options' => $options,
            ]);

            return $content;
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * @param ResponseInterface $response
     * @param string $mapTo
     * @param Exception|null $clientException
     * @return mixed
     * @throws JsonException
     * @throws TelegramException
     */
    protected function mapResponse(ResponseInterface $response, string $mapTo, Exception $clientException = null): mixed
    {
        $json = json_decode((string)$response->getBody(), flags: JSON_THROW_ON_ERROR);
        $json = $this->fireHandlersBy(self::AFTER_API_REQUEST, [$json]) ?? $json;
        if ($json?->ok) {
            return match (true) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => $this->hydrator->hydrateArray($json->result, $mapTo),
                default => $this->hydrator->hydrate($json->result, $mapTo)
            };
        }

        $e = new TelegramException(
            message: $json?->description ?? 'Client exception',
            code: $json?->error_code ?? 0,
            previous: $clientException,
            parameters: (array)($json?->parameters ?? []),
        );

        if (!empty($this->handlers[self::API_ERROR])) {
            return $this->fireExceptionHandlerBy(self::API_ERROR, $e);
        }

        throw $e;
    }

    /**
     * Returns the inline_message_id or
     * chat_id + message_id combination based on the current update.
     * The array is empty if none of them are set.
     * @param array $opt
     * @return array
     */
    protected function targetChatMessageOrInlineMessageId(array $opt = []): array
    {
        $inlineMessageId = $this->inlineMessageId();

        if ($inlineMessageId !== null && !isset($opt['chat_id']) && !isset($opt['message_id'])) {
            return ['inline_message_id' => $inlineMessageId];
        }

        return array_filter([
            'chat_id' => $this->chatId(),
            'message_id' => $this->messageId(),
        ]);
    }

    /**
     * Chunk a string into an array of strings.
     * @param string $text
     * @param int $length
     * @return array
     */
    protected function chunkText(string $text, int $length): array
    {
        return explode('%#TGMSG#%', StrUtils::wordWrap($text, $length, "%#TGMSG#%", true));
    }

    protected function redactTokenFromConnectException(ConnectException $e): void
    {
        throw new ConnectException(
            str_replace($this->token, str_repeat('*', 5), $e->getMessage()),
            $e->getRequest(),
            $e->getPrevious(),
            $e->getHandlerContext(),
        );
    }
}
