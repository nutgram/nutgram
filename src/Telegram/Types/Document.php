<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a general file (as opposed to
 * {@see https://core.telegram.org/bots/api#photosize photos},
 * {@see https://core.telegram.org/bots/api#voice voice messages} and
 * {@see https://core.telegram.org/bots/api#audio audio files}).
 * @see https://core.telegram.org/bots/api#document
 */
class Document
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
     * Optional. Document thumbnail as defined by sender
     * @var PhotoSize $thumb
     */
    public $thumb;

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
}
