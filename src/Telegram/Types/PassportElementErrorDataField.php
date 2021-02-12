<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an issue in one of the data fields that was provided by the user. The error is considered resolved when
 * the field's value changes. Class PassportElementErrorDataField
 * @see https://core.telegram.org/bots/api#passportelementerrordatafield
 */
class PassportElementErrorDataField
{
    /**
     * Error source, must be data
     * @var string
     */
    public string $source;

    /**
     * The section of the user's Telegram Passport which has the error, one of “personal_details”,
     * “passport”, “driver_license”, “identity_card”, “internal_passport”, “address”
     * @var string
     */
    public string $type;

    /**
     * Name of the data field which has the error
     * @var string
     */
    public string $field_name;

    /**
     * Base64-encoded data hash
     * @var string
     */
    public string $data_hash;

    /**
     * Error message
     * @var string
     */
    public string $message;
}
