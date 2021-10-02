<?php

namespace SergiX44\Nutgram\Telegram\Types\Common;

/**
 * Response from an API request
 * @see https://core.telegram.org/bots/api#making-requests
 */
class Response
{
    /**
     * Response status
     */
    public bool $ok;

    /**
     * An Integer field but its contents are subject to change in the future.
     */
    public int $error_code;

    /**
     * Optional field with a human-readable description of the result.
     */
    public ?string $description = null;

    /**
     * Result data
     */
    public object $result;

    /**
     * Optional field which can help to automatically handle the error.
     */
    public ?ResponseParameters $parameters = null;
}
