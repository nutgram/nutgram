<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Media\LivePhoto;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * The paid media is a {@see https://core.telegram.org/bots/api#livephoto live photo}.
 * @see https://core.telegram.org/bots/api#paidmedialivephoto
 */
class PaidMediaLivePhoto extends PaidMedia
{
    /**
     * Type of the paid media, always “live_photo”
     */
    #[EnumOrScalar]
    public PaidMediaType|string $type = PaidMediaType::LIVE_PHOTO;

    /**
     * The photo
     */
    public LivePhoto $live_photo;
}
