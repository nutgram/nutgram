<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a user boosting a chat.
 * @see https://core.telegram.org/bots/api#chatboostadded
 */
class ChatBoostAdded extends BaseType
{
    /**
     * Number of boosts added by the user
     */
    public int $boost_count;
}
