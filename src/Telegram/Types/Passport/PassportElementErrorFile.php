<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents an issue with a document scan. The error is considered resolved when the file with the document scan
 * changes. Class PassportElementErrorFile
 * @see https://core.telegram.org/bots/api#passportelementerrorfile
 */
class PassportElementErrorFile extends BaseType
{
    /**
     * Error source, must be file
     */
    public string $source;

    /**
     * The section of the user's Telegram Passport which has the issue, one of “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
     */
    public string $type;

    /**
     * Base64-encoded file hash
     */
    public string $file_hash;

    /**
     * Error message
     */
    public string $message;
}
