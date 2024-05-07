<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;
use SergiX44\Nutgram\Telegram\Types\Media\Document;

/**
 * /**
 * The background is a wallpaper in the JPEG format.
 * @see https://core.telegram.org/bots/api#backgroundtypewallpaper
 */
class BackgroundTypeWallpaper extends BackgroundType
{
    /**
     * Type of the background, always “wallpaper”
     */
    #[EnumOrScalar]
    public BackgroundTypeType|string $type = BackgroundTypeType::WALLPAPER;

    /**
     * Document with the wallpaper
     */
    public Document $document;

    /**
     * Dimming of the background in dark themes, as a percentage; 0-100
     */
    public int $dark_theme_dimming;

    /**
     * Optional. True, if the wallpaper is downscaled to fit in a 450x450 square and then box-blurred with radius 12
     */
    public ?bool $is_blurred = null;

    /**
     * Optional. True, if the background moves slightly when the device is tilted
     */
    public ?bool $is_moving = null;
}
