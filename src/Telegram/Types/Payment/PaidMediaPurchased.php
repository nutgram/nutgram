<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about a paid media purchase.
 * @see https://core.telegram.org/bots/api#paidmediapurchased
 */
class PaidMediaPurchased extends BaseType
{
    /**
     * User who purchased the media
     */
    public User $from;

    /**
     * Bot-specified paid media payload
     */
    public string $paid_media_payload;
}
