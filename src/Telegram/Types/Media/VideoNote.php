<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Hydrator\Annotation\Alias;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a video message (available in Telegram apps as of v.4.0).
 * @see https://telegram.org/blog/video-messages-and-telescope video message
 * @see https://telegram.org/blog/video-messages-and-telescope v.4.0
 * @see https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends BaseType
{
    /**
     * Identifier for this file
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be
     * used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Video width and height (diameter of the video message) as defined by sender
     */
    public int $length;

    /**
     * Duration of the video in seconds as defined by sender
     */
    public int $duration;

    /**
     * Optional. Video thumbnail
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * @see $thumbnail
     * @deprecated Use thumbnail
     */
    #[Alias('thumbnail')]
    public ?PhotoSize $thumb = null;

    /**
     * Optional. File size
     */
    public ?int $file_size = null;
}
