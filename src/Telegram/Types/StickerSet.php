<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#stickerset
 */
class StickerSet
{
    /**
     * Sticker set name
     * @var string
     */
    public string $name;
    
    /**
     * Sticker set title
     * @var string
     */
    public string $title;
    
    /**
     * True, if the sticker is animated
     * @var bool
     */
    public bool $is_animated;
    
    /**
     * True, if the sticker set contains masks
     * @var bool
     */
    public bool $contains_masks;
    
    /**
     * List of all set stickers
     * @var Sticker[]
     */
    public array $stickers;
    
    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS format
     * @var PhotoSize
     */
    public PhotoSize $thumb;
}
