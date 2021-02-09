<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an issue with a list of scans. The error is considered resolved when the list of files containing the
 * scans changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfiles
 */
class PassportElementErrorFiles
{
    /**
     * Error source, must be files
     * @var string
     */
    public string $source;
    
    /**
     * The section of the user's Telegram Passport which has the issue, one of “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
     * @var string
     */
    public string $type;
    
    /**
     * Base64-encoded file hashes
     * @var string
     */
    public string $file_hash;
    
    /**
     * Error message
     * @var string
     */
    public string $message;
}
