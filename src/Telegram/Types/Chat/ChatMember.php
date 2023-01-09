<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about one member of a chat. Currently, the following 6 types of chat members are
 * supported:
 * @see ChatMemberOwner
 * @see ChatMemberAdministrator
 * @see ChatMemberMember
 * @see ChatMemberRestricted
 * @see ChatMemberLeft
 * @see ChatMemberBanned
 *
 * @see https://core.telegram.org/bots/api#chatmember
 */
#[ChatMemberResolver]
abstract class ChatMember extends BaseType
{
    /**
     * Information about the user
     */
    public User $user;

    abstract public function getType(): string;
}
