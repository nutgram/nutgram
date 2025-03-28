<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The paid media to send is a photo.
 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
 */
#[OverrideConstructor('bindToInstance')]
class InputPaidMediaPhoto extends InputPaidMedia implements JsonSerializable
{
    /**
     * Type of the media, must be photo
     */
    #[EnumOrScalar]
    public InputPaidMediaType|string $type = InputPaidMediaType::PHOTO;


    public function __construct(
        InputFile|string $media,
    ) {
        parent::__construct();
        $this->media = $media;
    }



    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
        ]);
    }
}
