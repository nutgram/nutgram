<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * Describes a service message about the rejection of a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostdeclined
 */
class SuggestedPostDeclined extends BaseType
{
    /**
     * Optional. Message containing the suggested post.
     * Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply.
     */
    public ?Message $suggested_post_message = null;

    /**
     * Optional. Comment with which the post was declined
     */
    public ?string $comment = null;
}
