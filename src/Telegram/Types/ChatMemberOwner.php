<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that owns the chat and has all administrator privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
trait ChatMemberOwner
{
    /**
     * The member's status in the chat, always “creator”
     * @var string $status
     */
    public $status;

    /**
     * True, if the user's presence in the chat is hidden
     * @var bool $is_anonymous
     */
    public $is_anonymous;

    /**
     * Optional. Custom title for this user
     * @var string $custom_title
     */
    public $custom_title;
}
