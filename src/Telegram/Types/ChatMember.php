<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains information about one member of a chat. Currently, the following 6 types of chat members are supported:
 * - ChatMemberOwner
 * - ChatMemberAdministrator
 * - ChatMemberMember
 * - ChatMemberRestricted
 * - ChatMemberLeft
 * - ChatMemberBanned
 *
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMember
{
    /**
     * Information about the user
     * @var User $user
     */
    public $user;
}
