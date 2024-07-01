<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\PaidMediaType;

/**
 * The paid media isn't available before the payment.
 * @see https://core.telegram.org/bots/api#paidmediapreview
 */
class PaidMediaPreview extends PaidMedia
{
    /**
     * Type of the paid media, always “preview”
     */
    #[EnumOrScalar]
    public PaidMediaType|string $type = PaidMediaType::PREVIEW;

    /**
     * Optional. Media width as defined by the sender
     */
    public ?int $width;

    /**
     * Optional. Media height as defined by the sender
     */
    public ?int $height;

    /**
     * Optional. Duration of the media in seconds as defined by the sender
     */
    public ?int $duration;
}
