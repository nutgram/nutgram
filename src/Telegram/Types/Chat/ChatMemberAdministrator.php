<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Attributes\ChatMemberType;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member} that has some additional privileges.
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
class ChatMemberAdministrator extends ChatMember
{
    /**
     * The member's status in the chat, always “administrator”
     */
    public string $status = 'administrator';

    /**
     * True, if the bot is allowed to edit administrator privileges of that user
     */
    public ?bool $can_be_edited = null;

    /**
     * True, if the user's presence in the chat is hidden
     */
    public ?bool $is_anonymous = null;

    /**
     * True, if the administrator can access the chat event log, chat statistics, message statistics in channels,
     * see channel members, see anonymous administrators in supergroups and ignore slow mode.
     * Implied by any other administrator privilege
     */
    public ?bool $can_manage_chat = null;

    /**
     * True, if the administrator can delete messages of other users
     */
    public ?bool $can_delete_messages = null;

    /**
     * True, if the administrator can manage video chats
     */
    public ?bool $can_manage_video_chats = null;

    /**
     * True, if the administrator can restrict, ban or unban chat members
     */
    public ?bool $can_restrict_members = null;

    /**
     * True, if the administrator can add new administrators with a subset of his own
     * privileges or demote administrators that he has promoted, directly or indirectly
     * (promoted by administrators that were appointed by the user)
     */
    public ?bool $can_promote_members = null;

    /**
     * True, if the user is allowed to change the chat title, photo and other settings
     */
    public ?bool $can_change_info = null;

    /**
     * True, if the user is allowed to invite new users to the chat
     */
    public ?bool $can_invite_users = null;

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
     * Optional. True, if the user is allowed to create, rename, close, and reopen forum topics; supergroups only
     */
    public ?bool $can_manage_topics = null;

    /**
     * Optional. Custom title for this user
     */
    public ?string $custom_title = null;

    public function getType(): string
    {
        return ChatMemberType::ADMINISTRATOR;
    }
}
