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
     * @var string $name
     */
    public $name;

    /**
     * Sticker set title
     * @var string $title
     */
    public $title;

    /**
     * True, if the sticker is animated
     * @var bool $is_animated
     */
    public $is_animated;

    /**
     * True, if the sticker set contains masks
     * @var bool $contains_masks
     */
    public $contains_masks;

    /**
     * List of all set stickers
     * @var Sticker[] $stickers
     */
    public $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS format
     * @var PhotoSize $thumb
     */
    public $thumb;
}
