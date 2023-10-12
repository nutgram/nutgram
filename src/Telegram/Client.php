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
use SergiX44\Nutgram\Telegram\Endpoints\AvailableMethods;
use SergiX44\Nutgram\Telegram\Endpoints\CustomEndpoints;
use SergiX44\Nutgram\Telegram\Endpoints\Games;
use SergiX44\Nutgram\Telegram\Endpoints\InlineMode;
use SergiX44\Nutgram\Telegram\Endpoints\Passport;
use SergiX44\Nutgram\Telegram\Endpoints\Payments;
use SergiX44\Nutgram\Telegram\Endpoints\Stickers;
use SergiX44\Nutgram\Telegram\Endpoints\UpdateMethods;
use SergiX44\Nutgram\Telegram\Endpoints\UpdatesMessages;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;
use SergiX44\Nutgram\Telegram\Types\Internal\UploadableArray;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use stdClass;
use function SergiX44\Nutgram\Support\array_filter_null;
use function SergiX44\Nutgram\Support\word_wrap;

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
        Macroable,
        UpdateMethods,
        ProvidesHttpResponse;

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
        array $parameters,
        array $clientOpt = [],
        ?string $mapTo = null,
    ): ?Message {
        $type = match(true) {
            isset($parameters[MessageType::PHOTO->value]) => MessageType::PHOTO->value,
            isset($parameters[MessageType::AUDIO->value]) => MessageType::AUDIO->value,
            isset($parameters[MessageType::DOCUMENT->value]) => MessageType::DOCUMENT->value,
            isset($parameters[MessageType::VIDEO->value]) => MessageType::VIDEO->value,
            isset($parameters[MessageType::VIDEO_NOTE->value]) => MessageType::VIDEO_NOTE->value,
            isset($parameters[MessageType::ANIMATION->value]) => MessageType::ANIMATION->value,
            isset($parameters[MessageType::VOICE->value]) => MessageType::VOICE->value,
            isset($parameters[MessageType::STICKER->value]) => MessageType::STICKER->value,
        };

        if (!isset($parameters[$type])) {
            return null;
        }

        $file = &$parameters[$type];

        if (is_resource($file)) {
            $file = new InputFile($file);
        }

        if (!$file instanceof InputFile) {
            return $this->prepareAndSendRequest($endpoint, $parameters, $mapTo ?? Message::class);
        }

        return $this->requestMultipart($endpoint, $parameters, $mapTo ?? Message::class, $clientOpt);
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
     */
    public function downloadUrl(File $file): string|null
    {
        if ($this->config->isLocal) {
            if (isset($this->config->localPathTransformer)) {
                return $this->invoke($this->config->localPathTransformer, [$file->file_path]);
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
            if ($contents instanceof UploadableArray || $contents instanceof Uploadable) {
                $files = $contents instanceof UploadableArray ? $contents->files : [$contents];
                foreach ($files as $file) {
                    if ($file->isLocal()) {
                        $parameters[] = [
                            'name' => $file->getFilename(),
                            'contents' => $file->getResource(),
                            'filename' => $file->getFilename(),
                        ];
                    }
                }
            }

            $parameters[] = match (true) {
                $contents instanceof InputFile => [
                    'name' => $name,
                    'contents' => $contents->getResource(),
                    'filename' => $contents->getFilename(),
                ],
                $contents instanceof JsonSerializable, is_array($contents) => [
                    'name' => $name,
                    'contents' => json_encode($contents, JSON_THROW_ON_ERROR),
                ],
                default => [
                    'name' => $name,
                    'contents' => $contents instanceof BackedEnum ? $contents->value : $contents,
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
    protected function prepareAndSendRequest(
        string $endpoint,
        array $parameters = [],
        string $mapTo = stdClass::class,
        array $options = [],
    ): mixed {
        $parameters = $this->prepareAndGetCommonParameters($parameters);
        $type = match(true) {
            isset($parameters[MessageType::PHOTO->value]) => MessageType::PHOTO->value,
            isset($parameters[MessageType::AUDIO->value]) => MessageType::AUDIO->value,
            isset($parameters[MessageType::DOCUMENT->value]) => MessageType::DOCUMENT->value,
            isset($parameters[MessageType::VIDEO->value]) => MessageType::VIDEO->value,
            isset($parameters[MessageType::VIDEO_NOTE->value]) => MessageType::VIDEO_NOTE->value,
            isset($parameters[MessageType::ANIMATION->value]) => MessageType::ANIMATION->value,
            isset($parameters[MessageType::VOICE->value]) => MessageType::VOICE->value,
            isset($parameters[MessageType::STICKER->value]) => MessageType::STICKER->value,
            default => null,
        };
        $isAttachment = isset($parameters[$type]);
        if ($isAttachment) {
            $file = &$parameters[$type];
            if (is_resource($file)) {
                $file = new InputFile($file);
            }
            if (!is_string($file)) {
                $multipart = [];
                foreach ($parameters as $k => $v) {
                    $files = match(true) {
                        $v instanceof UploadableArray => $v->files,
                        $v instanceof Uploadable => [$v],
                        default => null,
                    };
                    if ($files) {
                        foreach ($files as $file) {
                            if ($file->isLocal()) {
                                $multipart[] = [
                                    'name' => $file->getFilename(),
                                    'contents' => $file->getResource(),
                                    'filename' => $file->getFilename(),
                                ];
                            }
                        }
                    } else {
                        $multipart[] = match (true) {
                            $v instanceof InputFile => [
                                'name' => $k,
                                'contents' => $v->getResource(),
                                'filename' => $v->getFilename(),
                            ],
                            $v instanceof JsonSerializable, is_array($v) => [
                                'name' => $k,
                                'contents' => json_encode($v, JSON_THROW_ON_ERROR),
                            ],
                            default => [
                                'name' => $k,
                                'contents' => $v instanceof BackedEnum ? $v->value : $v,
                            ]
                        };
                    }
                }
                $request = ['multipart' => $multipart, ...$options];
                try {
                    $requestPost = $this->fireHandlersBy(self::BEFORE_API_REQUEST, [$request]);
                    try {
                        $response = $this->http->post(
                            $endpoint,
                            $requestPost ?? $request
                        );
                    } catch (ConnectException $e) {
                        $this->redactTokenFromConnectException($e);
                    }
                    $content = $this->mapResponse($response, $mapTo);
                    $this->logger->debug($endpoint, [
                        'content' => $content,
                        'parameters' => $multipart,
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
        } else {
            $parameters = array_map(fn ($item) => match (true) {
                $item instanceof BackedEnum => $item->value,
                default => $item,
            }, array_filter_null($parameters));
            $request = ['json' => $parameters, ...$options];
    
            try {
                $requestPost = $this->fireHandlersBy(self::BEFORE_API_REQUEST, [$request]);
                $requestData = $requestPost ?? $request;
                if ($this->canHandleAsResponse()) {
                    return $this->sendResponse($endpoint, $requestData);
                }
                try {
                    $json = $requestData['json'];
                    unset($requestData['json']);
    
                    $response = $this->http->post(
                        $endpoint,
                        [
                            'body' => json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                            'headers' => ['Content-Type' => 'application/json'],
                            ...$requestData,
                        ]
                    );
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

        if (!$json?->ok) {
            $e = new TelegramException(
                message: $json?->description ?? 'Client exception',
                code: $json?->error_code ?? 0,
                previous: $clientException,
                parameters: (array)($json?->parameters ?? []),
            );

            return $this->fireExceptionHandlerBy(self::API_ERROR, $e);
        }

        return match (true) {
            is_scalar($json->result) => $json->result,
            is_array($json->result) => $this->hydrator->hydrateArray($json->result, $mapTo),
            default => $this->hydrator->hydrate($json->result, $mapTo)
        };
    }

    /**
     * Sets the chat_id + message_id or inline_message_id combination based on the current update.
     * @param array $parameters
     * @return array
     */
    protected function prepareAndGetCommonParameters(array $parameters = []): array
    {
        if (isset($parameters['clientOpt'])) {
            unset($parameters['clientOpt']);
        }
        $inlineMessageId = $this->inlineMessageId();
        if ($inlineMessageId !== null && empty($parameters['chat_id']) && empty($parameters['message_id'])) {
            $parameters['inline_message_id'] ??= $inlineMessageId;
        } else {
            if (key_exists('chat_id', $parameters) && !$parameters['chat_id']) {
                $parameters['chat_id'] ??= $this->chatId();
            }
            if (key_exists('message_id', $parameters) && !$parameters['message_id']) {
                $parameters['message_id'] ??= $this->messageId();
            }
            if (key_exists('user_id', $parameters) && !$parameters['user_id']) {
                $parameters['user_id'] ??= $this->userId();
            }
            if (key_exists('from_chat_id', $parameters) && !$parameters['from_chat_id']) {
                $parameters['from_chat_id'] ??= $this->chatId();
            }
            if (key_exists('callback_query_id', $parameters) && !$parameters['callback_query_id']) {
                $parameters['callback_query_id'] ??= $this->callbackQuery()?->id;
            }
            if (key_exists('shipping_query_id', $parameters) && !$parameters['shipping_query_id']) {
                $parameters['shipping_query_id'] ??= $this->shippingQuery()?->id;
            }
            if (key_exists('pre_checkout_query_id', $parameters) && !$parameters['pre_checkout_query_id']) {
                $parameters['pre_checkout_query_id'] ??= $this->preCheckoutQuery()?->id;
            }
            if (key_exists('inline_query_id', $parameters) && !$parameters['inline_query_id']) {
                $parameters['inline_query_id'] ??= $this->inlineQuery()?->id;
            }
        }
        return $parameters;
    }

    /**
     * Chunk a string into an array of strings.
     * @param string $text
     * @param int $length
     * @return array
     */
    protected function chunkText(string $text, int $length): array
    {
        return explode('%#TGMSG#%', word_wrap($text, $length, "%#TGMSG#%", true));
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
