<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the rights of an administrator in a chat.
 * @see https://core.telegram.org/bots/api#chatadministratorrights
 */
#[OverrideConstructor('bindToInstance')]
class ChatAdministratorRights extends BaseType
{
    /** True, if the user's presence in the chat is hidden */
    public bool $is_anonymous;

    /**
     * True, if the administrator can access the chat event log, chat statistics, message statistics in channels, see channel members, see anonymous administrators in supergroups and ignore slow mode.
     * Implied by any other administrator privilege
     */
    public bool $can_manage_chat;

    /** True, if the administrator can delete messages of other users */
    public bool $can_delete_messages;

    /** True, if the administrator can manage video chats */
    public bool $can_manage_video_chats;

    /** True, if the administrator can restrict, ban or unban chat members */
    public bool $can_restrict_members;

    /** True, if the administrator can add new administrators with a subset of their own privileges or demote administrators that they have promoted, directly or indirectly (promoted by administrators that were appointed by the user) */
    public bool $can_promote_members;

    /** True, if the user is allowed to change the chat title, photo and other settings */
    public bool $can_change_info;

    /** True, if the user is allowed to invite new users to the chat */
    public bool $can_invite_users;

    /**
     * Optional.
     * True, if the administrator can post in the channel;
     * channels only
     */
    public ?bool $can_post_messages = null;

    /**
     * Optional.
     * True, if the administrator can edit messages of other users and can pin messages;
     * channels only
     */
    public ?bool $can_edit_messages = null;

    /**
     * Optional.
     * True, if the user is allowed to pin messages;
     * groups and supergroups only
     */
    public ?bool $can_pin_messages = null;

    /**
     * Optional. True, if the administrator can post stories in the channel; channels only
     */
    public ?bool $can_post_stories = null;

    /**
     * Optional. True, if the administrator can edit stories posted by other users; channels only
     */
    public ?bool $can_edit_stories = null;

    /**
     * Optional. True, if the administrator can delete stories posted by other users; channels only
     */
    public ?bool $can_delete_stories = null;

    /**
     * Optional.
     * True, if the user is allowed to create, rename, close, and reopen forum topics;
     * supergroups only
     */
    public ?bool $can_manage_topics = null;

    /**
     * Optional.
     * True, if the administrator can manage direct messages of the channel and decline suggested posts;
     * for channels only
     */
    public ?bool $can_manage_direct_messages = null;

    public function __construct(
        bool $is_anonymous,
        bool $can_manage_chat,
        bool $can_delete_messages,
        bool $can_manage_video_chats,
        bool $can_restrict_members,
        bool $can_promote_members,
        bool $can_change_info,
        bool $can_invite_users,
        ?bool $can_post_messages = null,
        ?bool $can_edit_messages = null,
        ?bool $can_pin_messages = null,
        ?bool $can_post_stories = null,
        ?bool $can_edit_stories = null,
        ?bool $can_delete_stories = null,
        ?bool $can_manage_topics = null,
        ?bool $can_manage_direct_messages = null,
    ) {
        parent::__construct();
        $this->is_anonymous = $is_anonymous;
        $this->can_manage_chat = $can_manage_chat;
        $this->can_delete_messages = $can_delete_messages;
        $this->can_manage_video_chats = $can_manage_video_chats;
        $this->can_restrict_members = $can_restrict_members;
        $this->can_promote_members = $can_promote_members;
        $this->can_change_info = $can_change_info;
        $this->can_invite_users = $can_invite_users;
        $this->can_post_messages = $can_post_messages;
        $this->can_edit_messages = $can_edit_messages;
        $this->can_pin_messages = $can_pin_messages;
        $this->can_manage_topics = $can_manage_topics;
        $this->can_post_stories = $can_post_stories;
        $this->can_edit_stories = $can_edit_stories;
        $this->can_delete_stories = $can_delete_stories;
        $this->can_manage_direct_messages = $can_manage_direct_messages;
    }
}
