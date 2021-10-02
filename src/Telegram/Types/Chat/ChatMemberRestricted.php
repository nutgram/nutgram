<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that is under certain restrictions in the chat. Supergroups only.
 *
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 */
trait ChatMemberRestricted
{
    /**
     * The member's status in the chat, always “member”
     * @var string $status
     */
    public $status;

    /**
     * Optional. Restricted only. True, if the user is a member of the chat at the moment of the request
     * @var bool $is_member
     */
    public $is_member;

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
     * Date when restrictions will be lifted for this user; unix time. If 0, then the user is banned forever
     * @var int $until_date
     */
    public $until_date;
}
