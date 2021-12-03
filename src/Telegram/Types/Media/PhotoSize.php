<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one size of a photo or a file / sticker thumbnail.
 * @see https://core.telegram.org/bots/api#document file
 * @see https://core.telegram.org/bots/api#sticker sticker
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends BaseType
{
    /**
     * Unique identifier for this file
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Photo width
     */
    public int $width;

    /**
     * Photo height
     */
    public int $height;

    /**
     * Optional. File size
     */
    public ?int $file_size = null;
}
