<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an issue in an unspecified place.
 * The error is considered resolved when new data is added.
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
class PassportElementErrorUnspecified
{
    /**
     * Error source, must be unspecified
     * @var string $source
     */
    public $source;
    
    /**
     * Type of element of the user's Telegram Passport which has the issue
     * @var string $type
     */
    public $type;
    
    /**
     * Base64-encoded element hash
     * @var string $element_hash
     */
    public $element_hash;
    
    /**
     * Error message
     * @var string $message
     */
    public $message;
}
