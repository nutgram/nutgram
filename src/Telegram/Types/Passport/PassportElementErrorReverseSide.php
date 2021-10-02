<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

/**
 * Represents an issue with the reverse side of a document. The error is considered resolved when the file with reverse
 * side of the document changes. Class PassportElementErrorReverseSide
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
class PassportElementErrorReverseSide
{
    /**
     * Error source, must be reverse_side
     * @var string $source
     */
    public $source;

    /**
     * The section of the user's Telegram Passport which has the issue, one of “driver_license”, “identity_card”
     * @var string $type
     */
    public $type;

    /**
     * Base64-encoded hash of the file with the reverse side of the document
     * @var string $file_hash
     */
    public $file_hash;

    /**
     * Error message
     * @var string $message
     */
    public $message;
}
