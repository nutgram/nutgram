<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about one member of a chat.
 * Currently, the following 6 types of chat members are supported:
 * - {@see ChatMemberOwner ChatMemberOwner}
 * - {@see ChatMemberAdministrator ChatMemberAdministrator}
 * - {@see ChatMemberMember ChatMemberMember}
 * - {@see ChatMemberRestricted ChatMemberRestricted}
 * - {@see ChatMemberLeft ChatMemberLeft}
 * - {@see ChatMemberBanned ChatMemberBanned}
 * @see https://core.telegram.org/bots/api#chatmember
 */
#[ChatMemberResolver]
abstract class ChatMember extends BaseType
{
    /**
     * The member's status in the chat
     */
    #[EnumOrScalar]
    public ChatMemberStatus|string $status;

    /**
     * Information about the user
     */
    public User $user;
}
