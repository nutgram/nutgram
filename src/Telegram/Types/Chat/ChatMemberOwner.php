<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that owns the chat and has all administrator privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
class ChatMemberOwner extends ChatMember
{
    /** The member's status in the chat, always “creator” */
    #[EnumOrScalar]
    public ChatMemberStatus|string $status = ChatMemberStatus::CREATOR;

    /** Information about the user */
    public User $user;

    /** True, if the user's presence in the chat is hidden */
    public bool $is_anonymous;

    /**
     * Optional.
     * Custom title for this user
     */
    public ?string $custom_title = null;
}
