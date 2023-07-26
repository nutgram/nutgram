<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;

/**
 * This object represents a general file (as opposed to {@see https://core.telegram.org/bots/api#photosize photos}, {@see https://core.telegram.org/bots/api#voice voice messages} and {@see https://core.telegram.org/bots/api#audio audio files}).
 * @see https://core.telegram.org/bots/api#document
 */
class Document extends BaseType
{
    use Downloadable;

    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Optional.
     * Document thumbnail as defined by sender
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * Optional.
     * Original filename as defined by sender
     */
    public ?string $file_name = null;

    /**
     * Optional.
     * MIME type of the file as defined by sender
     */
    public ?string $mime_type = null;

    /**
     * Optional.
     * File size in bytes.
     * It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
     */
    public ?int $file_size = null;
}
