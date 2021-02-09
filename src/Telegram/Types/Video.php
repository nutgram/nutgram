<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a video file.
 * @see https://core.telegram.org/bots/api#video
 */
class Video
{
    /**
     * Identifier for this file
     * @var string
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string
     */
    public string $file_unique_id;

    /**
     * Video width as defined by sender
     * @var int
     */
    public int $width;

    /**
     * Video height as defined by sender
     * @var int
     */
    public int $height;

    /**
     * Duration of the video in seconds as defined by sender
     * @var int
     */
    public int $duration;

    /**
     * Optional. Video thumbnail
     * @var PhotoSize
     */
    public PhotoSize $thumb;

    /**
     * Optional. Original filename as defined by sender
     * @var string
     */
    public string $file_name;

    /**
     * Optional. Mime type of a file as defined by sender
     * @var string
     */
    public string $mime_type;

    /**
     * Optional. File size
     * @var int
     */
    public int $file_size;
}
