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
     * @var string
     */
    public string $source;

    /**
     * Type of element of the user's Telegram Passport which has the issue
     * @var string
     */
    public string $type;

    /**
     * Base64-encoded element hash
     * @var string
     */
    public string $element_hash;

    /**
     * Error message
     * @var string
     */
    public string $message;
}
