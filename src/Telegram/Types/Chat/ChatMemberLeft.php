<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Attributes\ChatMemberType;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that isn't currently a member of the chat, but may join it themselves.
 *
 * @see https://core.telegram.org/bots/api#chatmemberleft
 */
class ChatMemberLeft extends ChatMember
{
    /**
     * The member's status in the chat, always “left”
     */
    public string $status = 'left';

    public function getType(): string
    {
        return ChatMemberType::LEFT;
    }
}
