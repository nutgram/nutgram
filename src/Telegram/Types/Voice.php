<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a voice note.
 * @see https://core.telegram.org/bots/api#voice
 */
class Voice
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
     * Duration of the audio in seconds as defined by sender
     * @var int $duration
     */
    public $duration;

    /**
     * Optional. MIME type of the file as defined by sender
     * @var string $mime_type
     */
    public $mime_type;

    /**
     * Optional. File size
     * @var int $file_size
     */
    public $file_size;
}
