<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains information about one member of a chat.
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMember
{
    /**
     * Information about the user
     * @var User $user
     */
    public $user;

    /**
     * The member's status in the chat. Can be “creator”, “administrator”, “member”, “restricted”, “left” or “kicked”
     * @var string $status
     */
    public $status;

    /**
     * Optional. Owner and administrators only. Custom title for this user
     * @var string $custom_title
     */
    public $custom_title;

    /**
     * Optional. Owner and administrators only. True, if the user's presence in the chat is hidden
     * @var bool $is_anonymous
     */
    public $is_anonymous;

    /**
     * Optional. Administrators only. True, if the bot is allowed to edit administrator privileges of that user
     * @var bool $can_be_edited
     */
    public $can_be_edited;

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
     * Optional. Administrators only. True, if the administrator can delete messages of other users
     * @var bool $can_delete_messages
     */
    public $can_delete_messages;

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
     * Optional. Administrators and restricted only.
     * True, if the user is allowed to pin messages; groups and supergroups only
     * @var bool $can_pin_messages
     */
    public $can_pin_messages;

    /**
     * Optional. Restricted only. True, if the user is a member of the chat at the moment of the request
     * @var bool $is_member
     */
    public $is_member;

    /**
     * Optional. Restricted only. True, if the user can send text messages, contacts, locations and venues
     * @var bool $can_send_messages
     */
    public $can_send_messages;

    /**
     * Optional. Restricted only.
     * True, if the user can send audios, documents, photos, videos,
     * video notes and voice notes, implies can_send_messages
     * @var bool $can_send_media_messages
     */
    public $can_send_media_messages;

    /**
     * Optional. Restricted only. True, if the user is allowed to send polls
     * @var bool $can_send_polls
     */
    public $can_send_polls;

    /**
     * Optional. Restricted only.
     * True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages
     * @var bool $can_send_other_messages
     */
    public $can_send_other_messages;

    /**
     * Optional. Restricted only.
     * True, if user may add web page previews to his messages, implies can_send_media_messages
     * @var bool $can_add_web_page_previews
     */
    public $can_add_web_page_previews;

    /**
     * Optional. Restricted and kicked only. Date when restrictions will be lifted for this user; unix time
     * @var int $until_date
     */
    public $until_date;
}
