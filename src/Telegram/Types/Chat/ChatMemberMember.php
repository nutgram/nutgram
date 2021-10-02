<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that has no additional privileges or restrictions.
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
trait ChatMemberMember
{
    /**
     * The member's status in the chat, always “member”
     * @var string $status
     */
    public $status;
}
