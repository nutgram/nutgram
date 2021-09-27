<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that has some additional privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
trait ChatMemberAdministrator
{
    /**
     * The member's status in the chat, always “administrator”
     * @var string $status
     */
    public $status;

    /**
     * Optional. Administrators only. True, if the bot is allowed to edit administrator privileges of that user
     * @var bool $can_be_edited
     */
    public $can_be_edited;

    /**
     * True, if the user's presence in the chat is hidden
     * @var bool $is_anonymous
     */
    public $is_anonymous;

    /**
     * Optional. Administrators only.
     * True, if the administrator can access the chat event log, chat statistics, message statistics in channels,
     * see channel members, see anonymous administrators in supergroups and ignore slow mode.
     * Implied by any other administrator privilege
     * @var bool $can_manage_chat
     */
    public $can_manage_chat;

    /**
     * Optional. Administrators only. True, if the administrator can delete messages of other users
     * @var bool $can_delete_messages
     */
    public $can_delete_messages;

    /**
     * Optional. Administrators only. True, if the administrator can manage voice chats
     * @var bool $can_manage_voice_chats
     */
    public $can_manage_voice_chats;

    /**
     * Optional. Administrators only. True, if the administrator can restrict, ban or unban chat members
     * @var bool $can_restrict_members
     */
    public $can_restrict_members;

    /**
     * Optional. Administrators only.
     * True, if the administrator can add new administrators with a subset of his own
     * privileges or demote administrators that he has promoted, directly or indirectly
     * (promoted by administrators that were appointed by the user)
     * @var bool $can_promote_members
     */
    public $can_promote_members;

    /**
     * Optional. Administrators and restricted only.
     * True, if the user is allowed to change the chat title, photo and other settings
     * @var bool $can_change_info
     */
    public $can_change_info;

    /**
     * Optional. Administrators and restricted only. True, if the user is allowed to invite new users to the chat
     * @var bool $can_invite_users
     */
    public $can_invite_users;

    /**
     * Optional. Administrators only. True, if the administrator can post in the channel, channels only
     * @var bool $can_post_messages
     */
    public $can_post_messages;

    /**
     * Optional. Administrators only. True, if the administrator can edit messages of other users, channels only
     * @var bool $can_edit_messages
     */
    public $can_edit_messages;

    /**
     * Optional. Administrators and restricted only.
     * True, if the user is allowed to pin messages; groups and supergroups only
     * @var bool $can_pin_messages
     */
    public $can_pin_messages;

    /**
     * Optional. Custom title for this user
     * @var string $custom_title
     */
    public $custom_title;
}
