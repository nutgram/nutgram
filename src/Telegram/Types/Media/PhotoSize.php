<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

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
     * Photo width
     * @var int $width
     */
    public $width;

    /**
     * Photo height
     * @var int $height
     */
    public $height;

    /**
     * Optional. File size
     * @var int $file_size
     */
    public $file_size;
}
