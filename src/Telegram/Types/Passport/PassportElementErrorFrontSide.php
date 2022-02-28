<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents an issue with the front side of a document. The error is considered resolved when the file with the front
 * side of the document changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfrontside
 */
class PassportElementErrorFrontSide extends BaseType
{
    /**
     * Error source, must be front_side
     */
    public string $source;

    /**
     * The section of the user's Telegram Passport which has the error, one of “personal_details”,
     * “passport”, “driver_license”, “identity_card”, “internal_passport”
     */
    public string $type;

    /**
     * Base64-encoded hash of the file with the front side of the document
     */
    public string $file_hash;

    /**
     * Error message
     */
    public string $message;
}
