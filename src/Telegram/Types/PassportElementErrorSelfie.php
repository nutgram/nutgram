<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an issue with the selfie with a document.
 * The error is considered resolved when the file with the selfie changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
class PassportElementErrorSelfie
{
    /**
     * @var string $source Error source, must be selfie
     */
    public $source;
    
    /**
     * @var string $type The section of the user's Telegram Passport which has the issue, one of “passport”,
     *     “driver_license”, “identity_card”, “internal_passport”
     */
    public $type;
    
    /**
     * @var string $file_hash Base64-encoded hash of the file with the selfie
     */
    public $file_hash;
    
    /**
     * @var string $message Error message
     */
    public $message;
}
