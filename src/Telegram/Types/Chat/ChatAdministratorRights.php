<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the rights of an administrator in a chat.
 * @see https://core.telegram.org/bots/api#chatadministratorrights
 */
class ChatAdministratorRights extends BaseType
{
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
     * True, if the administrator can manage video chats
     */
    public bool $can_manage_video_chats;

    /**
     * True, if the administrator can restrict, ban or unban chat members
     */
    public bool $can_restrict_members;

    /**
     * True, if the administrator can add new administrators with a subset of their own privileges
     * or demote administrators that he has promoted, directly
     * or indirectly (promoted by administrators that were appointed by the user)
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
     * Optional. True, if the administrator can post in the channel; channels only
     */
    public ?bool $can_post_messages = null;

    /**
     * Optional. True, if the administrator can edit messages of other users and can pin messages; channels only
     */
    public ?bool $can_edit_messages = null;

    /**
     * Optional. True, if the user is allowed to pin messages; groups and supergroups only
     */
    public ?bool $can_pin_messages = null;

    /**
     * Optional. True, if the user is allowed to create, rename, close, and reopen forum topics; supergroups only
     */
    public ?bool $can_manage_topics = null;
}
