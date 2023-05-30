<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue in one of the data fields that was provided by the user.
 * The error is considered resolved when the field's value changes.
 * @see https://core.telegram.org/bots/api#passportelementerrordatafield
 */
class PassportElementErrorDataField extends PassportElementError
{
    /** Error source, must be data */
    public PassportSource $source = PassportSource::DATA;

    /** The section of the user's Telegram Passport which has the error, one of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address” */
    public PassportType $type;

    /** Name of the data field which has the error */
    public string $field_name;

    /** Base64-encoded data hash */
    public string $data_hash;

    /** Error message */
    public string $message;
}
