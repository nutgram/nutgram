<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;

/**
 * This object represents a video file.
 * @see https://core.telegram.org/bots/api#video
 */
class Video extends BaseType
{
    use Downloadable;

    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /** Video width as defined by sender */
    public int $width;

    /** Video height as defined by sender */
    public int $height;

    /** Duration of the video in seconds as defined by sender */
    public int $duration;

    /**
     * Optional.
     * Video thumbnail
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * Optional.
     * Original filename as defined by sender
     */
    public ?string $file_name = null;

    /**
     * Optional.
     * MIME type of the file as defined by sender
     */
    public ?string $mime_type = null;

    /**
     * Optional.
     * File size in bytes.
     * It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
     */
    public ?int $file_size = null;
}
