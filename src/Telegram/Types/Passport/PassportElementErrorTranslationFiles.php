<?php

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents an issue with the translated version of a document.
 * The error is considered resolved when a file with the document translation change.
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfiles
 */
class PassportElementErrorTranslationFiles extends PassportElementError
{
    /** Error source, must be translation_files */
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::TRANSLATION_FILES;

    /** Type of element of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
    #[EnumOrScalar]
    public PassportType|string $type;

    /**
     * List of base64-encoded file hashes
     * @var string[] $file_hashes
     */
    public array $file_hashes;

    /** Error message */
    public string $message;

    /**
     * @param PassportType|string $type
     * @param string[] $file_hashes
     * @param string $message
     */
    public function __construct(
        PassportType|string $type,
        array $file_hashes,
        string $message,
    ) {
        parent::__construct();
        $this->type = $type;
        $this->file_hashes = $file_hashes;
        $this->message = $message;
    }

    /**
     * @param PassportType|string $type
     * @param string[] $file_hashes
     * @param string $message
     * @return self
     */
    public static function make(
        PassportType|string $type,
        array $file_hashes,
        string $message,
    ): self {
        return new self(
            type: $type,
            file_hashes: $file_hashes,
            message: $message
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'source' => $this->source,
            'type' => $this->type,
            'file_hashes' => $this->file_hashes,
            'message' => $this->message,
        ]);
    }
}
