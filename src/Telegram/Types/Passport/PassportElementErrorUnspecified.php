<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Passport;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PassportSource;
use SergiX44\Nutgram\Telegram\Properties\PassportType;

/**
 * Represents an issue in an unspecified place.
 * The error is considered resolved when new data is added.
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
#[OverrideConstructor('bindToInstance')]
class PassportElementErrorUnspecified extends PassportElementError
{
    /** Error source, must be unspecified */
    #[EnumOrScalar]
    public PassportSource|string $source = PassportSource::UNSPECIFIED;

    /** Type of element of the user's Telegram Passport which has the issue */
    #[EnumOrScalar]
    public PassportType|string $type;

    /** Base64-encoded element hash */
    public string $element_hash;

    /** Error message */
    public string $message;

    public function __construct(
        PassportType|string $type,
        string $element_hash,
        string $message
    ) {
        parent::__construct();
        $this->type = $type;
        $this->element_hash = $element_hash;
        $this->message = $message;
    }
}
