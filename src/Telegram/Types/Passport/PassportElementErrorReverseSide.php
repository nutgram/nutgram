<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with the reverse side of a document.
 * The error is considered resolved when the file with reverse side of the document changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
class PassportElementErrorReverseSide extends PassportElementError
{
    /** Error source, must be reverse_side */
    public PassportSource $source = PassportSource::REVERSE_SIDE;

    /** The section of the user's Telegram Passport which has the issue, one of “driver_license”, “identity_card” */
    public PassportType $type;

    /** Base64-encoded hash of the file with the reverse side of the document */
    public string $file_hash;

    /** Error message */
    public string $message;
}
