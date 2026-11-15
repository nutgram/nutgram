<?php

namespace SergiX44\Nutgram\Telegram\Types\Community;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a service message about a chat being joined by a user from a community.
 * @see https://core.telegram.org/bots/api#communitychatjoined
 */
class CommunityChatJoined extends BaseType
{
    /**
     * The community from which the chat was joined
     */
    public Community $community;
}
