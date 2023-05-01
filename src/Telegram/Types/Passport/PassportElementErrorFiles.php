<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with a list of scans.
 * The error is considered resolved when the list of files containing the scans changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfiles
 */
class PassportElementErrorFiles extends PassportElementError
{
    /** Base64-encoded file hashes */
    public string $file_hash;

    /** Error source, must be files */
    public PassportSource $source = PassportSource::FILES;

    /** The section of the user's Telegram Passport which has the issue, one of “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
    public PassportType $type;

    /**
     * List of base64-encoded file hashes
     * @var string[] $file_hashes
     */
    public array $file_hashes;

    /** Error message */
    public string $message;
}
