<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

/**
 * This object represents an audio file to be treated as music by the Telegram clients.
 * @see https://core.telegram.org/bots/api#audio
 */
class Audio
{
    /**
     * Identifier for this file
     * @var string $file_id
     */
    public $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string $file_unique_id
     */
    public $file_unique_id;

    /**
     * Duration of the audio in seconds as defined by sender
     * @var int $duration
     */
    public $duration;

    /**
     * Optional. Performer of the audio as defined by sender or by audio tags
     * @var string $performer
     */
    public $performer;

    /**
     * Optional. Title of the audio as defined by sender or by audio tags
     * @var string $title
     */
    public $title;

    /**
     * Optional. Original filename as defined by sender
     * @var string $file_name
     */
    public $file_name;

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

    /**
     * Optional. Thumbnail of the album cover to which the music file belongs
     * @var PhotoSize $thumb
     */
    public $thumb;
}
