<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#sticker
 */
class Sticker
{
    /**
     * Identifier for this file
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Sticker width
     */
    public int $width;

    /**
     * Sticker height
     */
    public int $height;

    /**
     * True, if the sticker is {@see https://telegram.org/blog/animated-stickers animated}
     */
    public bool $is_animated;

    /**
     * Optional. Sticker thumbnail in .webp or .jpg format
     */
    public ?PhotoSize $thumb = null;

    /**
     * Optional. Emoji associated with the sticker
     */
    public ?string $emoji = null;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     */
    public ?string $set_name = null;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     */
    public ?MaskPosition $mask_position = null;

    /**
     * Optional. File size
     */
    public ?int $file_size = null;
}
