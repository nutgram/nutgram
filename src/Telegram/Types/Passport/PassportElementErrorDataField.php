<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents an issue in one of the data fields that was provided by the user.
 * The error is considered resolved when the field's value changes.
 * @see https://core.telegram.org/bots/api#passportelementerrordatafield
 */
class PassportElementErrorDataField extends PassportElementError
{
    /** Error source, must be data */
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::DATA;

    /** The section of the user's Telegram Passport which has the error, one of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address” */
    #[EnumOrScalar]
    public PassportType|string $type;

    /** Name of the data field which has the error */
    public string $field_name;

    /** Base64-encoded data hash */
    public string $data_hash;

    /** Error message */
    public string $message;

    public function __construct(
        PassportType|string $type,
        string $field_name,
        string $data_hash,
        string $message
    ) {
        parent::__construct();
        $this->type = $type;
        $this->field_name = $field_name;
        $this->data_hash = $data_hash;
        $this->message = $message;
    }

    public static function make(
        PassportType $type,
        string $field_name,
        string $data_hash,
        string $message
    ): self {
        return new self(
            type: $type,
            field_name: $field_name,
            data_hash: $data_hash,
            message: $message
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'source' => $this->source->value,
            'type' => $this->type->value,
            'field_name' => $this->field_name,
            'data_hash' => $this->data_hash,
            'message' => $this->message,
        ]);
    }
}
