<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\Currency;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Payment\StarAmount;

/**
 * Describes a service message about a successful payment for a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostpaid
 */
class SuggestedPostPaid extends BaseType
{
    /**
     * Optional. Message containing the suggested post.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public ?Message $suggested_post_message = null;

    /**
     * Currency in which the payment was made.
     * Currently, one of “XTR” for Telegram Stars or “TON” for toncoins
     */
    #[EnumOrScalar]
    public Currency|string $currency;

    /**
     * Optional. The amount of the currency that was received by the channel in nanotoncoins;
     * for payments in toncoins only
     */
    public ?int $amount = null;

    /**
     * Optional. The amount of Telegram Stars that was received by the channel;
     * for payments in Telegram Stars only
     */
    public ?StarAmount $star_amount = null;
}
