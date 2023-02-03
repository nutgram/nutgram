<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes actions that a non-administrator user is allowed to take in a chat.
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions extends BaseType
{
    /**
     * Optional. True, if the user is allowed to send text messages, contacts, locations and venues
     */
    public ?bool $can_send_messages = null;

    /**
     * Optional. True, if the user is allowed to send audios
     */
    public ?bool $can_send_audios = null;

    /**
     * Optional. True, if the user is allowed to send documents
     */
    public ?bool $can_send_documents = null;

    /**
     * Optional. True, if the user is allowed to send photos
     */
    public ?bool $can_send_photos = null;

    /**
     * Optional. True, if the user is allowed to send videos
     */
    public ?bool $can_send_videos = null;

    /**
     * Optional. True, if the user is allowed to send video notes
     */
    public ?bool $can_send_video_notes = null;

    /**
     * Optional. True, if the user is allowed to send voice notes
     */
    public ?bool $can_send_voice_notes = null;

    /**
     * Optional. True, if the user is allowed to send polls, implies can_send_messages
     */
    public ?bool $can_send_polls = null;

    /**
     * Optional. True, if the user is allowed to send animations, games, stickers and use inline bots, implies can_send_media_messages
     */
    public ?bool $can_send_other_messages = null;

    /**
     * Optional. True, if the user is allowed to add web page previews to their messages, implies can_send_media_messages
     */
    public ?bool $can_add_web_page_previews = null;

    /**
     * Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
     */
    public ?bool $can_change_info = null;

    /**
     * Optional. True, if the user is allowed to invite new users to the chat
     */
    public ?bool $can_invite_users = null;

    /**
     * Optional. True, if the user is allowed to pin messages. Ignored in public supergroups
     */
    public ?bool $can_pin_messages = null;

    /**
     * Optional. True, if the user is allowed to create forum topics.
     * If omitted defaults to the value of can_pin_messages
     */
    public ?bool $can_manage_topics = null;
}
