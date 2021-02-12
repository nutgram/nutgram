<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one size of a photo or a file / sticker thumbnail.
 * @see https://core.telegram.org/bots/api#document file
 * @see https://core.telegram.org/bots/api#sticker sticker
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize
{
    /**
     * Unique identifier for this file
     * @var string
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string
     */
    public string $file_unique_id;

    /**
     * Photo width
     * @var int
     */
    public int $width;

    /**
     * Photo height
     * @var int
     */
    public int $height;

    /**
     * Optional. File size
     * @var int
     */
    public int $file_size;
}
