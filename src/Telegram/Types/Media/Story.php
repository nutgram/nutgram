<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object represents a message about a forwarded story in the chat. Currently holds no information.
 * @see https://core.telegram.org/bots/api#story
 */
class Story extends BaseType
{
    /**
     * Chat that posted the story
     */
    public Chat $chat;

    /**
     * Unique identifier for the story in the chat
     */
    public int $id;
}
