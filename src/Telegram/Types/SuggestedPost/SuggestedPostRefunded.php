<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\SuggestedPostRefundedReason;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * Describes a service message about a payment refund for a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostrefunded
 */
class SuggestedPostRefunded extends BaseType
{
    /**
     * Optional. Message containing the suggested post.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public Message|null $suggested_post_message = null;

    /**
     * Reason for the refund. Currently, one of
     * “post_deleted” if the post was deleted within 24 hours of being posted or removed from scheduled messages without being posted,
     * or “payment_refunded” if the payer refunded their payment.
     */
    #[EnumOrScalar]
    public SuggestedPostRefundedReason|string $reason;
}
