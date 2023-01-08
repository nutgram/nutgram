<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * Represents a {@see https://core.telegram.org/bots/api#chatmember chat member}
 * that is under certain restrictions in the chat. Supergroups only.
 *
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 */
class ChatMemberRestricted extends ChatMember
{
    /**
     * The member's status in the chat, always “restricted”
     */
    public string $status;

    /**
     * True, if the user is a member of the chat at the moment of the request
     */
    public ?bool $is_member = null;

    /**
     * True, if the user is allowed to change the chat title, photo and other settings
     */
    public ?bool $can_change_info = null;

    /**
     * True, if the user is allowed to invite new users to the chat
     */
    public ?bool $can_invite_users = null;

    /**
     * True, if the user is allowed to pin messages; groups and supergroups only
     */
    public ?bool $can_pin_messages = null;

    /**
     * True, if the user is allowed to create forum topics
     */
    public ?bool $can_manage_topics = null;

    /**
     * True, if the user can send text messages, contacts, locations and venues
     */
    public ?bool $can_send_messages = null;

    /**
     * True, if the user can send audios, documents, photos, videos,
     * video notes and voice notes, implies can_send_messages
     */
    public ?bool $can_send_media_messages = null;

    /**
     * True, if the user is allowed to send polls
     */
    public ?bool $can_send_polls = null;

    /**
     * True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages
     */
    public ?bool $can_send_other_messages = null;

    /**
     * True, if user may add web page previews to his messages, implies can_send_media_messages
     */
    public ?bool $can_add_web_page_previews = null;

    /**
     * Date when restrictions will be lifted for this user; unix time. If 0, then the user is banned forever
     */
    public ?int $until_date = null;
}
