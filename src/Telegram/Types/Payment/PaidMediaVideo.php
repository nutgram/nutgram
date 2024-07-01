<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Media\Video;

/**
 * The paid media is a video.
 * @see https://core.telegram.org/bots/api#paidmediavideo
 */
class PaidMediaVideo extends PaidMedia
{
    /**
     * Type of the paid media, always “video”
     */
    #[EnumOrScalar]
    public PaidMediaType|string $type = PaidMediaType::VIDEO;

    /**
     * The video
     */
    public Video $video;
}
