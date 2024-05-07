<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a chat background.
 * @see https://core.telegram.org/bots/api#chatbackground
 */
class ChatBackground extends BaseType
{
    /**
     * Type of the background
     */
    public BackgroundType $type;
}
