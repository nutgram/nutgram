<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that was banned in the chat and can't return to the chat or view chat messages.
 * @see https://core.telegram.org/bots/api#chatmemberbanned
 */
class ChatMemberBanned extends ChatMember
{
    /** The member's status in the chat, always “kicked” */
    #[EnumOrScalar]
    public ChatMemberStatus|string $status = ChatMemberStatus::KICKED;

    /** Information about the user */
    public User $user;

    /**
     * Date when restrictions will be lifted for this user;
     * unix time.
     * If 0, then the user is banned forever
     */
    public int $until_date;
}
