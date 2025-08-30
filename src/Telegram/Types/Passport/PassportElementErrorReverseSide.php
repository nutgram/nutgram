<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue with the reverse side of a document.
 * The error is considered resolved when the file with reverse side of the document changes.
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 */
#[OverrideConstructor('bindToInstance')]
class PassportElementErrorReverseSide extends PassportElementError
{
    /** Error source, must be reverse_side */
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::REVERSE_SIDE;

    /** The section of the user's Telegram Passport which has the issue, one of “driver_license”, “identity_card” */
    #[EnumOrScalar]
    public PassportType|string $type;

    /** Base64-encoded hash of the file with the reverse side of the document */
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
}
