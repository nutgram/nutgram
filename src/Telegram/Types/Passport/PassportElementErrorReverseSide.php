<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents an issue with the reverse side of a document. The error is considered resolved when the file with reverse
 * side of the document changes. Class PassportElementErrorReverseSide
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
class PassportElementErrorReverseSide extends BaseType
{
    /**
     * Error source, must be reverse_side
     */
    public string $source;

    /**
     * The section of the user's Telegram Passport which has the issue, one of “driver_license”, “identity_card”
     */
    public string $type;

    /**
     * Base64-encoded hash of the file with the reverse side of the document
     */
    public string $file_hash;

    /**
     * Error message
     */
    public string $message;
}
