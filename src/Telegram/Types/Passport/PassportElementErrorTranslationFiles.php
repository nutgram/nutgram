<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents an issue with one of the files that constitute the translation of a document.
 * The error is considered resolved when the file changes.
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfiles
 */
class PassportElementErrorTranslationFiles extends BaseType
{
    /**
     * Error source, must be translation_files
     */
    public string $source;

    /**
     * Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”,
     * “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”,
     * “passport_registration”, “temporary_registration”
     */
    public string $type;

    /**
     * List of base64-encoded file hashes
     * @var string[] $file_hashes
     */
    public array $file_hashes;

    /**
     * Error message
     */
    public string $message;
}
