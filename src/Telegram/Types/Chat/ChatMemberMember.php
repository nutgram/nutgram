<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Attributes\ChatMemberType;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that has no additional privileges or restrictions.
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
class ChatMemberMember extends ChatMember
{
    /**
     * The member's status in the chat, always “member”
     */
    public string $status = 'member';

    public function getType(): string
    {
        return ChatMemberType::MEMBER;
    }
}
