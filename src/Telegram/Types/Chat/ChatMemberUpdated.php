<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents changes in the status of a chat member.
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated extends BaseType
{
    /** Chat the user belongs to */
    public Chat $chat;

    /** Performer of the action, which resulted in the change */
    public User $from;

    /** Date the change was done in Unix time */
    public int $date;

    /** Previous information about the chat member */
    public ChatMember $old_chat_member;

    /** New information about the chat member */
    public ChatMember $new_chat_member;

    /**
     * Optional.
     * Chat invite link, which was used by the user to join the chat;
     * for joining by invite link events only.
     */
    public ?ChatInviteLink $invite_link = null;

    /**
     * Optional. True, if the user joined the chat after sending a direct join request and being approved by an administrator
     */
    public ?bool $via_join_request = null;

    /**
     * Optional.
     * True, if the user joined the chat via a chat folder invite link
     */
    public ?bool $via_chat_folder_invite_link = null;
}
