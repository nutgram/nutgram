<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object represents a boost removed from a chat.
 * @see https://core.telegram.org/bots/api#chatboostremoved
 */
class ChatBoostRemoved extends BaseType
{
    /**
     * Chat which was boosted
     */
    public Chat $chat;

    /**
     * Unique identifier of the boost
     */
    public string $boost_id;

    /**
     * Point in time (Unix timestamp) when the boost was removed
     */
    public int $remove_date;

    /**
     * Source of the removed boost
     */
    public ChatBoostSource $source;
}
