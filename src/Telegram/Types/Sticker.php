<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#sticker
 */
class Sticker
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
     * Sticker width
     * @var int $width
     */
    public $width;

    /**
     * Sticker height
     * @var int $height
     */
    public $height;

    /**
     * True, if the sticker is {@see https://telegram.org/blog/animated-stickers animated}
     * @var bool $is_animated
     */
    public $is_animated;

    /**
     * Optional. Sticker thumbnail in .webp or .jpg format
     * @var PhotoSize $thumb
     */
    public $thumb;

    /**
     * Optional. Emoji associated with the sticker
     * @var string $emoji
     */
    public $emoji;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     * @var string $set_name
     */
    public $set_name;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     * @var MaskPosition $mask_position
     */
    public $mask_position;

    /**
     * Optional. File size
     * @var int $file_size
     */
    public $file_size;
}
