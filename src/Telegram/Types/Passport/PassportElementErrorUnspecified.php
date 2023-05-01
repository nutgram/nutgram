<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue in an unspecified place.
 * The error is considered resolved when new data is added.
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
class PassportElementErrorUnspecified extends PassportElementError
{
    /** Error source, must be unspecified */
    public PassportSource $source = PassportSource::UNSPECIFIED;

    /** Type of element of the user's Telegram Passport which has the issue */
    public PassportType $type;

    /** Base64-encoded element hash */
    public string $element_hash;

    /** Error message */
    public string $message;
}
