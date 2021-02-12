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
     * @var string
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     * @var string
     */
    public string $file_unique_id;

    /**
     * Sticker width
     * @var int
     */
    public int $width;

    /**
     * Sticker height
     * @var int
     */
    public int $height;

    /**
     * True, if the sticker is {@see https://telegram.org/blog/animated-stickers animated}
     * @var bool
     */
    public bool $is_animated;

    /**
     * Optional. Sticker thumbnail in .webp or .jpg format
     * @var PhotoSize
     */
    public PhotoSize $thumb;

    /**
     * Optional. Emoji associated with the sticker
     * @var string
     */
    public string $emoji;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     * @var string
     */
    public string $set_name;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     * @var MaskPosition
     */
    public MaskPosition $mask_position;

    /**
     * Optional. File size
     * @var int
     */
    public int $file_size;
}
