<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents an issue with a document scan.
 * The error is considered resolved when the file with the document scan changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorfile
 */
class PassportElementErrorFile extends PassportElementError
{
    /** Error source, must be file */
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::FILE;

    /** The section of the user's Telegram Passport which has the issue, one of “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
    #[EnumOrScalar]
    public PassportType|string $type;

    /** Base64-encoded file hash */
    public string $file_hash;

    /** Error message */
    public string $message;

    public function __construct(
        PassportType|string $type,
        string $file_hash,
        string $message
    ) {
        parent::__construct();
        $this->type = $type;
        $this->file_hash = $file_hash;
        $this->message = $message;
    }

    public static function make(
        PassportType $type,
        string $file_hash,
        string $message
    ): self {
        return new self(
            type: $type,
            file_hash: $file_hash,
            message: $message
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'source' => $this->source->value,
            'type' => $this->type->value,
            'file_hash' => $this->file_hash,
            'message' => $this->message,
        ]);
    }
}
