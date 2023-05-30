<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with the front side of a document.
 * The error is considered resolved when the file with the front side of the document changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfrontside
 */
class PassportElementErrorFrontSide extends PassportElementError
{
    /** Error source, must be front_side */
    public PassportSource $source = PassportSource::FRONT_SIDE;

    /** The section of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport” */
    public PassportType $type;

    /** Base64-encoded hash of the file with the front side of the document */
    public string $file_hash;

    /** Error message */
    public string $message;
}
