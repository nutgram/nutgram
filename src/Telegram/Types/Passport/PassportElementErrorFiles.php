<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;
use function SergiX44\Nutgram\Support\array_filter_null;

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
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::FILES;

    /** The section of the user's Telegram Passport which has the issue, one of “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration” */
    #[EnumOrScalar]
    public PassportType|string $type;

    /**
     * List of base64-encoded file hashes
     * @var string[] $file_hashes
     */
    public array $file_hashes;

    /** Error message */
    public string $message;

    public static function make(
        PassportType|string $type,
        array $file_hashes,
        string $message,
    ): self {
        $instance = new self;
        $instance->type = $type;
        $instance->file_hashes = $file_hashes;
        $instance->message = $message;

        return $instance;
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
