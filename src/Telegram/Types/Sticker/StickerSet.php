<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#stickerset
 */
class StickerSet
{
    /**
     * Sticker set name
     */
    public string $name;

    /**
     * Sticker set title
     */
    public string $title;

    /**
     * True, if the sticker is animated
     */
    public bool $is_animated;

    /**
     * True, if the sticker set contains masks
     */
    public bool $contains_masks;

    /**
     * List of all set stickers
     * @var \SergiX44\Nutgram\Telegram\Types\Sticker\Sticker[] $stickers
     */
    public array $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS format
     */
    public ?PhotoSize $thumb = null;
}
