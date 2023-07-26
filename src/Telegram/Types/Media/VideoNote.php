<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;

/**
 * This object represents a {@see https://telegram.org/blog/video-messages-and-telescope video message} (available in Telegram apps as of {@see https://telegram.org/blog/video-messages-and-telescope v.4.0}).
 * @see https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends BaseType
{
    use Downloadable;

    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /** Video width and height (diameter of the video message) as defined by sender */
    public int $length;

    /** Duration of the video in seconds as defined by sender */
    public int $duration;

    /**
     * Optional.
     * Video thumbnail
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * Optional.
     * File size in bytes
     */
    public ?int $file_size = null;
}
