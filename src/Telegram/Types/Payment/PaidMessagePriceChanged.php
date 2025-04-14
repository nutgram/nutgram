<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a service message about a change in the price of paid messages within a chat.
 * @see https://core.telegram.org/bots/api#paidmessagepricechanged
 */
class PaidMessagePriceChanged extends BaseType
{
    /**
     * The new number of Telegram Stars that must be paid by
     * non-administrator users of the supergroup chat for each sent message
     */
    public int $paid_message_star_count;
}
