<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#stickerset
 */
class StickerSet extends BaseType
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
     * Type of stickers in the set, currently one of “regular”, “mask”, “custom_emoji”
     */
    public string $sticker_type;

    /**
     * True, if the sticker set contains animated stickers
     */
    public bool $is_animated;

    /**
     * True, if the sticker set contains video stickers
     */
    public bool $is_video;

    /**
     * List of all set stickers
     * @var \SergiX44\Nutgram\Telegram\Types\Sticker\Sticker[] $stickers
     */
    #[ArrayType(Sticker::class)]
    public array $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS format
     */
    public ?PhotoSize $thumb = null;
}
