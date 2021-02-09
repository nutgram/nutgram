<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Response from an API request
 * @see https://core.telegram.org/bots/api#making-requests
 */
class Response
{
    /**
     * Response status
     * @var bool
     */
    public bool $ok;
    
    /**
     * An Integer field but its contents are subject to change in the future.
     * @var int
     */
    public int $error_code;
    
    /**
     * Optional field with a human-readable description of the result.
     * @var string
     */
    public string $description;
    
    /**
     * Result data
     * @var object
     */
    public object $result;
    
    /**
     * Optional field which can help to automatically handle the error.
     * @var ResponseParameters
     */
    public ResponseParameters $parameters;
}
