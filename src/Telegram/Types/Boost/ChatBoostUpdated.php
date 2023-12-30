<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object represents a boost added to a chat or changed.
 * @see https://core.telegram.org/bots/api#chatboostupdated
 */
class ChatBoostUpdated extends BaseType
{
    /**
     * Chat which was boosted
     */
    public Chat $chat;

    /**
     * Infomation about the chat boost
     */
    public ChatBoost $boost;
}
