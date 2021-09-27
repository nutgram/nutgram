<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that isn't currently a member of the chat, but may join it themselves.
 *
 * @see https://core.telegram.org/bots/api#chatmemberleft
 */
trait ChatMemberLeft
{
    /**
     * The member's status in the chat, always “left”
     * @var string $status
     */
    public $status;
}
