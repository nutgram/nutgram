<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes actions that a non-administrator user is allowed to take in a chat.
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions extends BaseType implements JsonSerializable
{
    /**
     * Optional.
     * True, if the user is allowed to send text messages, contacts, invoices, locations and venues
     */
    public ?bool $can_send_messages = null;

    /**
     * Optional.
     * True, if the user is allowed to send audios
     */
    public ?bool $can_send_audios = null;

    /**
     * Optional.
     * True, if the user is allowed to send documents
     */
    public ?bool $can_send_documents = null;

    /**
     * Optional.
     * True, if the user is allowed to send photos
     */
    public ?bool $can_send_photos = null;

    /**
     * Optional.
     * True, if the user is allowed to send videos
     */
    public ?bool $can_send_videos = null;

    /**
     * Optional.
     * True, if the user is allowed to send video notes
     */
    public ?bool $can_send_video_notes = null;

    /**
     * Optional.
     * True, if the user is allowed to send voice notes
     */
    public ?bool $can_send_voice_notes = null;

    /**
     * Optional.
     * True, if the user is allowed to send polls
     */
    public ?bool $can_send_polls = null;

    /**
     * Optional.
     * True, if the user is allowed to send animations, games, stickers and use inline bots
     */
    public ?bool $can_send_other_messages = null;

    /**
     * Optional.
     * True, if the user is allowed to add web page previews to their messages
     */
    public ?bool $can_add_web_page_previews = null;

    /**
     * Optional.
     * True, if the user is allowed to change the chat title, photo and other settings.
     * Ignored in public supergroups
     */
    public ?bool $can_change_info = null;

    /**
     * Optional.
     * True, if the user is allowed to invite new users to the chat
     */
    public ?bool $can_invite_users = null;

    /**
     * Optional.
     * True, if the user is allowed to pin messages.
     * Ignored in public supergroups
     */
    public ?bool $can_pin_messages = null;

    /**
     * Optional.
     * True, if the user is allowed to create forum topics.
     * If omitted defaults to the value of can_pin_messages
     */
    public ?bool $can_manage_topics = null;

    public function __construct(
        ?bool $can_send_messages = null,
        ?bool $can_send_audios = null,
        ?bool $can_send_documents = null,
        ?bool $can_send_photos = null,
        ?bool $can_send_videos = null,
        ?bool $can_send_video_notes = null,
        ?bool $can_send_voice_notes = null,
        ?bool $can_send_polls = null,
        ?bool $can_send_other_messages = null,
        ?bool $can_add_web_page_previews = null,
        ?bool $can_change_info = null,
        ?bool $can_invite_users = null,
        ?bool $can_pin_messages = null,
        ?bool $can_manage_topics = null,
    ) {
        parent::__construct();
        $this->can_send_messages = $can_send_messages;
        $this->can_send_audios = $can_send_audios;
        $this->can_send_documents = $can_send_documents;
        $this->can_send_photos = $can_send_photos;
        $this->can_send_videos = $can_send_videos;
        $this->can_send_video_notes = $can_send_video_notes;
        $this->can_send_voice_notes = $can_send_voice_notes;
        $this->can_send_polls = $can_send_polls;
        $this->can_send_other_messages = $can_send_other_messages;
        $this->can_add_web_page_previews = $can_add_web_page_previews;
        $this->can_change_info = $can_change_info;
        $this->can_invite_users = $can_invite_users;
        $this->can_pin_messages = $can_pin_messages;
        $this->can_manage_topics = $can_manage_topics;
    }

    public static function make(
        ?bool $can_send_messages = null,
        ?bool $can_send_audios = null,
        ?bool $can_send_documents = null,
        ?bool $can_send_photos = null,
        ?bool $can_send_videos = null,
        ?bool $can_send_video_notes = null,
        ?bool $can_send_voice_notes = null,
        ?bool $can_send_polls = null,
        ?bool $can_send_other_messages = null,
        ?bool $can_add_web_page_previews = null,
        ?bool $can_change_info = null,
        ?bool $can_invite_users = null,
        ?bool $can_pin_messages = null,
        ?bool $can_manage_topics = null,
    ): self {
        return new self(
            can_send_messages: $can_send_messages,
            can_send_audios: $can_send_audios,
            can_send_documents: $can_send_documents,
            can_send_photos: $can_send_photos,
            can_send_videos: $can_send_videos,
            can_send_video_notes: $can_send_video_notes,
            can_send_voice_notes: $can_send_voice_notes,
            can_send_polls: $can_send_polls,
            can_send_other_messages: $can_send_other_messages,
            can_add_web_page_previews: $can_add_web_page_previews,
            can_change_info: $can_change_info,
            can_invite_users: $can_invite_users,
            can_pin_messages: $can_pin_messages,
            can_manage_topics: $can_manage_topics,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'can_send_messages' => $this->can_send_messages,
            'can_send_audios' => $this->can_send_audios,
            'can_send_documents' => $this->can_send_documents,
            'can_send_photos' => $this->can_send_photos,
            'can_send_videos' => $this->can_send_videos,
            'can_send_video_notes' => $this->can_send_video_notes,
            'can_send_voice_notes' => $this->can_send_voice_notes,
            'can_send_polls' => $this->can_send_polls,
            'can_send_other_messages' => $this->can_send_other_messages,
            'can_add_web_page_previews' => $this->can_add_web_page_previews,
            'can_change_info' => $this->can_change_info,
            'can_invite_users' => $this->can_invite_users,
            'can_pin_messages' => $this->can_pin_messages,
            'can_manage_topics' => $this->can_manage_topics,
        ]);
    }
}
