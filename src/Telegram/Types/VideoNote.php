<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a video message (available in Telegram apps as of v.4.0).
 * @see https://telegram.org/blog/video-messages-and-telescope video message
 * @see https://telegram.org/blog/video-messages-and-telescope v.4.0
 * @see https://core.telegram.org/bots/api#videonote
 */
class VideoNote
{
    /**
     * Identifier for this file
     * @var string $file_id
     */
    public $file_id;
    
    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @var string $file_unique_id
     */
    public $file_unique_id;
    
    /**
     * Video width and height (diameter of the video message) as defined by sender
     * @var int $length
     */
    public $length;
    
    /**
     * Duration of the video in seconds as defined by sender
     * @var int $duration
     */
    public $duration;
    
    /**
     * Optional. Video thumbnail
     * @var PhotoSize $thumb
     */
    public $thumb;
    
    /**
     * Optional. File size
     * @var int $file_size
     */
    public $file_size;
}
