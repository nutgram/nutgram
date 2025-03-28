<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StickerType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents a sticker set.
 * @see https://core.telegram.org/bots/api#stickerset
 */
class StickerSet extends BaseType
{
    /**
     * Sticker set name
     */
    public string $name;

    /** Sticker set title */
    public string $title;

    /**
     * Type of stickers in the set, currently one of “regular”, “mask”, “custom_emoji”
     */
    #[EnumOrScalar]
    public StickerType|string $sticker_type;

    /**
     * List of all set stickers
     * @var Sticker[] $stickers
     */
    #[ArrayType(Sticker::class)]
    public array $stickers;

    /**
     * Optional.
     * Sticker set thumbnail in the .WEBP, .TGS, or .WEBM format
     */
    public ?PhotoSize $thumbnail = null;
}
