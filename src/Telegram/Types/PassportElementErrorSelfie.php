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
     * @var string Error source, must be selfie
     */
    public string $source;
    
    /**
     * @var string The section of the user's Telegram Passport which has the issue, one of “passport”,
     *     “driver_license”, “identity_card”, “internal_passport”
     */
    public string $type;
    
    /**
     * @var string Base64-encoded hash of the file with the selfie
     */
    public string $file_hash;
    
    /**
     * @var string Error message
     */
    public string $message;
}
