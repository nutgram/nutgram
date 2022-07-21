<?php


namespace SergiX44\Nutgram\Telegram;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Traits\Macroable;
use JsonException;
use JsonSerializable;
use Laminas\Stdlib\StringUtils;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait Client
 * @package SergiX44\Nutgram\Telegram
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
        Macroable;

    /**
     * Use this method to receive incoming updates using long polling.
     * An Array of Update objects is returned.
     * @see https://core.telegram.org/bots/api#getupdates
     * @see https://en.wikipedia.org/wiki/Push_technology#Long_polling
     * @param  array{offset?: int, limit?: int, timeout?: int, allowed_updates?: array<string>}  $parameters
     * @return array|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
     */
    public function getUpdates(array $parameters = []): ?array
    {
        return $this->requestJson(__FUNCTION__, $parameters, Update::class, [
            'timeout' => ($parameters['timeout'] ?? 0) + 1,
        ]);
    }

    /**
     * @param  string  $url
     * @param  null|array{certificate?: mixed, ip_address?: string, max_connections?: int,
     *     allowed_updates?:array<string>, drop_pending_updates?: bool}  $opt
     * @return bool|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
     */
    public function setWebhook(string $url, ?array $opt = []): ?bool
    {
        $required = compact('url');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  null|array{drop_pending_updates?: bool}  $opt
     * @return bool|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
     */
    public function deleteWebhook(?array $opt = []): ?bool
    {
        return $this->requestJson(__FUNCTION__, $opt);
    }

    /**
     * @return WebhookInfo|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
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
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
     */
    public function sendRequest(string $endpoint, ?array $parameters = [], ?array $options = []): mixed
    {
        return $this->requestMultipart($endpoint, $parameters, options: $options);
    }

    /**
     * @param  string  $endpoint
     * @param  string  $param
     * @param  mixed  $value
     * @param  array  $opt
     * @param  array  $clientOpt
     * @return Message|null
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
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
            return $this->requestMultipart($endpoint, array_merge($required, $opt), Message::class, $clientOpt);
        }

        return $this->requestJson($endpoint, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  File  $file
     * @param  string  $path
     * @param  array  $clientOpt
     * @return bool|null
     * @throws GuzzleException
     */
    public function downloadFile(File $file, string $path, array $clientOpt = []): ?bool
    {
        if (!is_dir(dirname($path)) && !mkdir(
            $concurrentDirectory = dirname($path),
            true,
            true
        ) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Error creating directory "%s"', $concurrentDirectory));
        }

        if ($this->config['is_local'] ?? false) {
            return copy($this->downloadUrl($file), $path);
        }

        $response = $this->http->get($this->downloadUrl($file), array_merge(['sink' => $path], $clientOpt));
        return $response->getStatusCode() === Response::HTTP_OK;
    }

    /**
     * @param  File  $file
     * @return string|null
     */
    public function downloadUrl(File $file): string|null
    {
        if (isset($this->config['is_local']) && $this->config['is_local']) {
            if (isset($this->config['local_path_transformer'])) {
                return call_user_func($this->resolve($this->config['local_path_transformer']), $file->file_path);
            }

            return $file->file_path;
        }

        $baseUri = $this->config['api_url'] ?? self::DEFAULT_API_URL;
        return "$baseUri/file/bot$this->token/$file->file_path";
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $multipart
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
     */
    protected function requestMultipart(
        string $endpoint,
        ?array $multipart = null,
        string $mapTo = stdClass::class,
        ?array $options = []
    ): mixed {
        $parameters = array_map(fn ($name, $contents) => match (true) {
            $contents instanceof InputFile => [
                'name' => $name,
                'contents' => $contents->getResource(),
                'filename' => $contents->getFilename(),
            ],
            $contents instanceof JsonSerializable => [
                'name' => $name,
                'contents' => json_encode($contents),
            ],
            default => [
                'name' => $name,
                'contents' => $contents,
            ]
        }, array_keys($multipart), $multipart);

        try {
            $response = $this->http->post($endpoint, array_merge(['multipart' => $parameters], $options));
            return $this->mapResponse($response, $mapTo);
        } catch (RequestException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * @param  string  $endpoint
     * @param  array|null  $json
     * @param  string  $mapTo
     * @param  array|null  $options
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws TelegramException
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
            return $this->mapResponse($exception->getResponse(), $mapTo, $exception);
        }
    }

    /**
     * @param  ResponseInterface  $response
     * @param  string  $mapTo
     * @param  Exception|null  $clientException
     * @return mixed
     * @throws JsonException
     * @throws TelegramException
     */
    protected function mapResponse(ResponseInterface $response, string $mapTo, Exception $clientException = null): mixed
    {
        $json = json_decode((string)$response->getBody(), flags: JSON_THROW_ON_ERROR);
        if ($json?->ok) {
            return match (true) {
                is_scalar($json->result) => $json->result,
                is_array($json->result) => $this->mapper->hydrateArray($json->result, $this->container->getNew($mapTo)),
                default => $this->mapper->hydrate($json->result, $this->container->getNew($mapTo))
            };
        }

        $e = new TelegramException(
            $json?->description ?? 'Client exception',
            $json?->error_code ?? 0,
            $clientException
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
     * @param  array  $opt
     * @return array
     */
    private function targetChatMessageOrInlineMessageId(array $opt = []): array
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
     * @param  string  $text
     * @param  int  $length
     * @return array
     */
    protected function chunkText(string $text, int $length = Limits::TEXT_LENGTH): array
    {
        return explode('%#TGMSG#%', $this->mb_wordwrap($text, $length, "%#TGMSG#%", true));
    }

    protected function g_strlen($str)
    {
        $len = grapheme_strlen($str);
        return $len ?? false;
    }

    protected function g_substr($str, $offset = 0, $length = null): bool|string
    {
        if ($length !== null) {
            return grapheme_substr($str, $offset, $length);
        }

        return grapheme_substr($str, $offset);
    }

    protected function mb_wordwrap($string, $width = 75, $break = "\n", $cut = false): string
    {
        $string = (string)$string;
        if ($string === '') {
            return '';
        }

        $break = (string)$break;
        if ($break === '') {
            throw new \InvalidArgumentException('Break string cannot be empty');
        }

        $width = (int)$width;
        if ($width === 0 && $cut) {
            throw new \InvalidArgumentException('Cannot force cut when width is zero');
        }

        $stringWidth = $this->g_strlen($string);
        $breakWidth = $this->g_strlen($break);

        $result = '';
        $lastStart = $lastSpace = 0;

        for ($current = 0; $current < $stringWidth; $current++) {
            $char = $this->g_substr($string, $current, 1);

            $possibleBreak = $char;
            if ($breakWidth !== 1) {
                $possibleBreak = $this->g_substr($string, $current, $breakWidth);
            }

            if ($possibleBreak === $break) {
                $result .= $this->g_substr($string, $lastStart, $current - $lastStart + $breakWidth);
                $current += $breakWidth - 1;
                $lastStart = $lastSpace = $current + 1;
                continue;
            }

            if ($char === ' ') {
                if ($current - $lastStart >= $width) {
                    $result .= $this->g_substr($string, $lastStart, $current - $lastStart).$break;
                    $lastStart = $current + 1;
                }

                $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $cut && $lastStart >= $lastSpace) {
                $result .= $this->g_substr($string, $lastStart, $current - $lastStart).$break;
                $lastStart = $lastSpace = $current;
                continue;
            }

            if ($current - $lastStart >= $width && $lastStart < $lastSpace) {
                $result .= $this->g_substr($string, $lastStart, $lastSpace - $lastStart).$break;
                $lastStart = $lastSpace += 1;
                continue;
            }
        }

        if ($lastStart !== $current) {
            $result .= $this->g_substr($string, $lastStart, $current - $lastStart);
        }

        return $result;
    }
}
