<?php

namespace SergiX44\Nutgram\Telegram\Web;

class WebAppChat extends Entity
{
    /**
     * Unique identifier for this chat.
     * This number may have more than 32 significant bits and some programming languages
     * may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision
     * float type are safe for storing this identifier.
     */
    public int $id;

    /**
     * Type of chat, can be either “group”, “supergroup” or “channel”
     */
    public string $type;

    /**
     * Title of the chat
     */
    public string $title;

    /**
     * Optional. Username of the chat
     */
    public ?string $username = null;

    /**
     * Optional. URL of the chat’s photo.
     * The photo can be in .jpeg or .svg formats.
     * Only returned for Web Apps launched from the attachment menu.
     */
    public ?string $photo_url = null;
}
