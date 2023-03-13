<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Hydrator\Annotation\Alias;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an audio file to be treated as music by the Telegram clients.
 * @see https://core.telegram.org/bots/api#audio
 */
class Audio extends BaseType
{
    /**
     * Identifier for this file
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Duration of the audio in seconds as defined by sender
     */
    public int $duration;

    /**
     * Optional. Performer of the audio as defined by sender or by audio tags
     */
    public ?string $performer = null;

    /**
     * Optional. Title of the audio as defined by sender or by audio tags
     */
    public ?string $title = null;

    /**
     * Optional. Original filename as defined by sender
     */
    public ?string $file_name = null;

    /**
     * Optional. MIME type of the file as defined by sender
     */
    public ?string $mime_type = null;

    /**
     * Optional. File size
     */
    public ?int $file_size = null;

    /**
     * Optional. Thumbnail of the album cover to which the music file belongs
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * @see $thumbnail
     * @deprecated Use thumbnail
     */
    #[Alias('thumbnail')]
    public ?PhotoSize $thumb = null;
}
