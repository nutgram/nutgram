<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StickerType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object represents a sticker.
 * @see https://core.telegram.org/bots/api#sticker
 */
class Sticker extends BaseType
{
    use Downloadable;

    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”.
     * The type of the sticker is independent from its format, which is determined by the fields is_animated and is_video.
     */
    #[EnumOrScalar]
    public StickerType|string $type;

    /** Sticker width */
    public int $width;

    /** Sticker height */
    public int $height;

    /** True, if the sticker is {@see https://telegram.org/blog/animated-stickers animated} */
    public bool $is_animated;

    /** True, if the sticker is a {@see https://telegram.org/blog/video-stickers-better-reactions video sticker} */
    public bool $is_video;

    /**
     * Optional.
     * Sticker thumbnail in the .WEBP or .JPG format
     */
    public ?PhotoSize $thumbnail = null;

    /**
     * Optional.
     * Emoji associated with the sticker
     */
    public ?string $emoji = null;

    /**
     * Optional.
     * Name of the sticker set to which the sticker belongs
     */
    public ?string $set_name = null;

    /**
     * Optional.
     * For premium regular stickers, premium animation for the sticker
     */
    public ?File $premium_animation = null;

    /**
     * Optional.
     * For mask stickers, the position where the mask should be placed
     */
    public ?MaskPosition $mask_position = null;

    /**
     * Optional.
     * For custom emoji stickers, unique identifier of the custom emoji
     */
    public ?string $custom_emoji_id = null;

    /**
     * Optional.
     * True, if the sticker must be repainted to a text color in messages, the color of the Telegram Premium badge in emoji status, white color on chat photos, or another appropriate color in other places
     */
    public ?bool $needs_repainting = null;

    /**
     * Optional.
     * File size in bytes
     */
    public ?int $file_size = null;
}
