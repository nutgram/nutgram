<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

/**
 * This object represents a chat photo.
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto
{
    /**
     * File identifier of small (160x160) chat photo.
     * This file_id can be used only for photo download and only for as long as the photo is not changed.
     * @var string $small_file_id
     */
    public $small_file_id;

    /**
     * Unique file identifier of small (160x160) chat photo,
     * which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string $small_file_unique_id
     */
    public $small_file_unique_id;

    /**
     * File identifier of big (640x640) chat photo.
     * This file_id can be used only for photo download and only for as long as the photo is not changed.
     * @var string $big_file_id
     */
    public $big_file_id;

    /**
     * Unique file identifier of big (640x640) chat photo,
     * which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string $big_file_unique_id
     */
    public $big_file_unique_id;
}
