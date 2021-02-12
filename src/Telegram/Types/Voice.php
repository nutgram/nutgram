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
     * @var string
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @var string
     */
    public string $file_unique_id;

    /**
     * Duration of the audio in seconds as defined by sender
     * @var int
     */
    public int $duration;

    /**
     * Optional. MIME type of the file as defined by sender
     * @var string
     */
    public string $mime_type;

    /**
     * Optional. File size
     * @var int
     */
    public int $file_size;
}
