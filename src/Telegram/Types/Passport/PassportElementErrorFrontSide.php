<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

/**
 * Represents an issue with the front side of a document. The error is considered resolved when the file with the front
 * side of the document changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfrontside
 */
class PassportElementErrorFrontSide
{
    /**
     * Error source, must be front_side
     * @var string $source
     */
    public $source;

    /**
     * The section of the user's Telegram Passport which has the error, one of “personal_details”,
     * “passport”, “driver_license”, “identity_card”, “internal_passport”
     * @var string $type
     */
    public $type;

    /**
     * Base64-encoded hash of the file with the front side of the document
     * @var string $file_hash
     */
    public $file_hash;

    /**
     * Error message
     * @var string $message
     */
    public $message;
}
