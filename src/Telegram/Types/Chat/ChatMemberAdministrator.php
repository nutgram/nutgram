<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that has some additional privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
trait ChatMemberAdministrator
{
    /**
     * The member's status in the chat, always “administrator”
     */
    public string $status;

    /**
     * True, if the bot is allowed to edit administrator privileges of that user
     */
    public bool $can_be_edited;

    /**
     * True, if the user's presence in the chat is hidden
     */
    public bool $is_anonymous;

    /**
     * True, if the administrator can access the chat event log, chat statistics, message statistics in channels,
     * see channel members, see anonymous administrators in supergroups and ignore slow mode.
     * Implied by any other administrator privilege
     */
    public bool $can_manage_chat;

    /**
     * True, if the administrator can delete messages of other users
     */
    public bool $can_delete_messages;

    /**
     * True, if the administrator can manage voice chats
     */
    public bool $can_manage_voice_chats;

    /**
     * True, if the administrator can restrict, ban or unban chat members
     */
    public bool $can_restrict_members;

    /**
     * True, if the administrator can add new administrators with a subset of his own
     * privileges or demote administrators that he has promoted, directly or indirectly
     * (promoted by administrators that were appointed by the user)
     */
    public bool $can_promote_members;

    /**
     * True, if the user is allowed to change the chat title, photo and other settings
     */
    public bool $can_change_info;

    /**
     * True, if the user is allowed to invite new users to the chat
     */
    public bool $can_invite_users;

    /**
     * Optional. Administrators only. True, if the administrator can post in the channel, channels only
     */
    public ?bool $can_post_messages = null;

    /**
     * Optional. Administrators only. True, if the administrator can edit messages of other users, channels only
     */
    public ?bool $can_edit_messages = null;

    /**
     * Optional. Administrators and restricted only.
     * True, if the user is allowed to pin messages; groups and supergroups only
     */
    public ?bool $can_pin_messages = null;

    /**
     * Optional. Custom title for this user
     */
    public ?string $custom_title = null;
}
