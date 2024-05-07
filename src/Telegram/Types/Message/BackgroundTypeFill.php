<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;

/**
 * The background is automatically filled based on the selected colors.
 * @see https://core.telegram.org/bots/api#backgroundtypefill
 */
class BackgroundTypeFill extends BackgroundType
{
    /**
     * Type of the background, always “fill”
     */
    #[EnumOrScalar]
    public BackgroundTypeType|string $type = BackgroundTypeType::FILL;

    /**
     * The background fill
     */
    public BackgroundFill $fill;

    /**
     * Dimming of the background in dark themes, as a percentage; 0-100
     */
    public int $dark_theme_dimming;
}
