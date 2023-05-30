<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a chat photo.
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto extends BaseType
{
    /**
     * File identifier of small (160x160) chat photo.
     * This file_id can be used only for photo download and only for as long as the photo is not changed.
     */
    public string $small_file_id;

    /**
     * Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $small_file_unique_id;

    /**
     * File identifier of big (640x640) chat photo.
     * This file_id can be used only for photo download and only for as long as the photo is not changed.
     */
    public string $big_file_id;

    /**
     * Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $big_file_unique_id;
}
