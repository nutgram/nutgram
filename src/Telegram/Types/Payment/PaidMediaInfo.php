<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the paid media added to a message.
 * @see https://core.telegram.org/bots/api#paidmediainfo
 */
class PaidMediaInfo extends BaseType
{
    /**
     * The number of Telegram Stars that must be paid to buy access to the media
     */
    public int $star_count;

    /**
     * Information about the paid media
     */
    #[ArrayType(PaidMedia::class)]
    public array $paid_media;
}
