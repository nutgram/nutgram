<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that has no additional privileges or restrictions.
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
class ChatMemberMember extends ChatMember
{
    /** The member's status in the chat, always “member” */
    #[EnumOrScalar]
    public ChatMemberStatus|string $status = ChatMemberStatus::MEMBER;

    /** Information about the user */
    public User $user;

    /**
     * Optional.
     * Date when the user's subscription will expire; Unix time
     */
    public ?int $until_date = null;
}
