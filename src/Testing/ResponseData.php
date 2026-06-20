<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Testing;

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use Throwable;
use function SergiX44\Nutgram\Support\dot_get;
use function SergiX44\Nutgram\Support\dot_has;

class ResponseData
{
    protected ?TelegramException $error = null;
    protected array $data = [];

    public function __construct(Response $response)
    {
        $this->parse($response);
    }

    protected function parse(Response $response): void
    {
        try {
            $body = (string)$response->getBody();
            $response = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
            $ok = $response['ok'] ?? false;

            if ($ok) {
                $this->data = $response['result'] ?? [];
                return;
            }

            $this->error = new TelegramException(
                message: $response['description'] ?? 'Client exception',
                code: $response['error_code'] ?? 0,
                parameters: $response['parameters'] ?? [],
            );
        } catch (Throwable) {
            // :/
        }
    }

    public function isOk(): bool
    {
        return $this->error === null;
    }

    public function error(): ?TelegramException
    {
        return $this->error;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return dot_get($this->data, $key, $default);
    }

    public function has(string $key): bool
    {
        return dot_has($this->data, $key);
    }

    public function missing(string $key): bool
    {
        return !$this->has($key);
    }
}
