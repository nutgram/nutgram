<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with the selfie with a document.
 * The error is considered resolved when the file with the selfie changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorselfie
 */
class PassportElementErrorSelfie extends PassportElementError
{
    /** Error source, must be selfie */
    public PassportSource $source = PassportSource::SELFIE;

    /** The section of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport” */
    public PassportType $type;

    /** Base64-encoded hash of the file with the selfie */
    public string $file_hash;

    /** Error message */
    public string $message;
}
