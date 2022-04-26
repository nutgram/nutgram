<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that owns the chat and has all administrator privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
trait ChatMemberOwner
{
    /**
     * The member's status in the chat, always “creator”
     */
    public string $status;

    /**
     * True, if the user's presence in the chat is hidden
     */
    public ?bool $is_anonymous = null;

    /**
     * Optional. Custom title for this user
     */
    public ?string $custom_title = null;
}
