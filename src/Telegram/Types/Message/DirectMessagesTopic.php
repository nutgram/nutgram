<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes a topic of a direct messages chat.
 * @see https://core.telegram.org/bots/api#directmessagestopic
 */
class DirectMessagesTopic extends BaseType
{
    /**
     * Unique identifier of the topic
     */
    public int $topic_id;

    /**
     * Optional. Information about the user that created the topic.
     * Currently, it is always present
     */
    public ?User $user = null;
}
