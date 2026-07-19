<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Community;

use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Describes a service message about a chat being added to a community.
 * @see https://core.telegram.org/bots/api#communitychatadded
 */
class CommunityChatAdded extends BaseType
{
    /**
     * The new community to which the chat belongs
     */
    public Community $community;
}
