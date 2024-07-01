<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * The paid media is a photo.
 * @see https://core.telegram.org/bots/api#paidmediaphoto
 */
class PaidMediaPhoto extends PaidMedia
{
    /**
     * Type of the paid media, always “photo”
     */
    #[EnumOrScalar]
    public PaidMediaType|string $type = PaidMediaType::PHOTO;

    /**
     * The photo
     * @var PhotoSize[]
     */
    #[ArrayType(PhotoSize::class)]
    public array $photo;
}
