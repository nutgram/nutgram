<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Hydrator\Annotation\Alias;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a general file (as opposed to
 * {@see https://core.telegram.org/bots/api#photosize photos},
 * {@see https://core.telegram.org/bots/api#voice voice messages} and
 * {@see https://core.telegram.org/bots/api#audio audio files}).
 * @see https://core.telegram.org/bots/api#document
 */
class Document extends BaseType
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
     * Optional. Document thumbnail as defined by sender
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * @see $thumbnail
     * @deprecated Use thumbnail
     */
    #[Alias('thumbnail')]
    public ?PhotoSize $thumb = null;

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
}
