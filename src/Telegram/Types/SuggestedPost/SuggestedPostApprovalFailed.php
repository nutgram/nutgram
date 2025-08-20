<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * Describes a service message about the failed approval of a suggested post.
 * Currently, only caused by insufficient user funds at the time of approval.
 * @see https://core.telegram.org/bots/api#suggestedpostapprovalfailed
 */
class SuggestedPostApprovalFailed extends BaseType
{
    /**
     * Optional. Message containing the suggested post whose approval has failed.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public ?Message $suggested_post_message = null;

    /**
     * Expected price of the post
     */
    public SuggestedPostPrice $price;
}
