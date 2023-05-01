<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with the translated version of a document.
 * The error is considered resolved when a file with the document translation change.
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfiles
 */
class PassportElementErrorTranslationFiles extends PassportElementError
{
    /** Error source, must be translation_files */
    public PassportSource $source = PassportSource::TRANSLATION_FILES;

    /** Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
    public PassportType $type;

    /**
     * List of base64-encoded file hashes
     * @var string[] $file_hashes
     */
    public array $file_hashes;

    /** Error message */
    public string $message;
}
