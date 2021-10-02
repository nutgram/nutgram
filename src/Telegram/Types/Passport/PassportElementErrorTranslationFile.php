<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

/**
 * Represents an issue with one of the files that constitute the translation of a document.
 * The error is considered resolved when the file changes
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfile
 */
class PassportElementErrorTranslationFile
{
    /**
     * Error source, must be translation_file
     * @var string $source
     */
    public $source;

    /**
     * Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”,
     * “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”,
     * “passport_registration”, “temporary_registration”
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
