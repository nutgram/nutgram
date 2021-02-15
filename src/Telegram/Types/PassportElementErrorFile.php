<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an issue with a document scan. The error is considered resolved when the file with the document scan
 * changes. Class PassportElementErrorFile
 * @see https://core.telegram.org/bots/api#passportelementerrorfile
 */
class PassportElementErrorFile
{
    /**
     * Error source, must be file
     * @var string $source
     */
    public $source;
    
    /**
     * The section of the user's Telegram Passport which has the issue, one of “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
     * @var string $type
     */
    public $type;
    
    /**
     * Base64-encoded file hash
     * @var string $file_hash
     */
    public $file_hash;
    
    /**
     * Error message
     * @var string $message
     */
    public $message;
}
