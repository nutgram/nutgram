<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents changes in the status of a chat member.
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated
{
    /**
     * Chat the user belongs to
     * @var Chat $chat
     */
    public $chat;

    /**
     * Performer of the action, which resulted in the change
     * @var User $from
     */
    public $from;

    /**
     *  Date the change was done in Unix time
     * @var int $date
     */
    public $date;

    /**
     * Previous information about the chat member
     * @var ChatMember $old_chat_member
     */
    public $old_chat_member;

    /**
     * New information about the chat member
     * @var ChatMember $new_chat_member
     */
    public $new_chat_member;

    /**
     * Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
     * @var ChatInviteLink $invite_link
     */
    public $invite_link;
}
