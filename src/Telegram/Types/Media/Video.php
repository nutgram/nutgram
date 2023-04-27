<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Hydrator\Annotation\Alias;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a video file.
 *
 * @see https://core.telegram.org/bots/api#video
 */
class Video extends BaseType
{
    /**
     * Identifier for this file.
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Video width as defined by sender.
     */
    public int $width;

    /**
     * Video height as defined by sender.
     */
    public int $height;

    /**
     * Duration of the video in seconds as defined by sender.
     */
    public int $duration;

    /**
     * Optional. Video thumbnail.
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * @see $thumbnail
     * @deprecated Use thumbnail
     */
    #[Alias('thumbnail')]
    public ?PhotoSize $thumb = null;

    /**
     * Optional. Original filename as defined by sender.
     */
    public ?string $file_name = null;

    /**
     * Optional. Mime type of a file as defined by sender.
     */
    public ?string $mime_type = null;

    /**
     * Optional. File size.
     */
    public ?int $file_size = null;
}
