<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains information about a chat boost.
 * @see https://core.telegram.org/bots/api#chatboost
 */
class ChatBoost extends BaseType
{
    /**
     * Unique identifier of the boost
     */
    public string $boost_id;

    /**
     * Point in time (Unix timestamp) when the chat was boosted
     */
    public int $add_date;

    /**
     * Point in time (Unix timestamp) when the boost will automatically expire, unless the booster's Telegram Premium subscription is prolonged
     */
    public int $expiration_date;

    /**
     * Source of the added boost
     */
    public ChatBoostSource $source;
}
