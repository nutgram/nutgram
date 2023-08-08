<?php

namespace SergiX44\Nutgram\Telegram\Exceptions;

use Exception;

class TelegramException extends Exception
{
    protected array $parameters;

    /**
     * TelegramException constructor.
     * @param $message
     * @param int $code
     * @param  array  $parameters
     * @param  null  $previous
     */
    public function __construct($message = '', int $code = 0, $previous = null, array $parameters = [])
    {
        $this->parameters = $parameters;
        parent::__construct($message, $code, $previous);
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getParameter(string $key, mixed $default = null): mixed
    {
        return $this->parameters[$key] ?? $default;
    }

    public function hasParameter(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }
}
