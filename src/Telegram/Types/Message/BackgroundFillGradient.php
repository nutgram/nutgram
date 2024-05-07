<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;

/**
 * The background is a gradient fill.
 * @see https://core.telegram.org/bots/api#backgroundfillgradient
 */
class BackgroundFillGradient extends BackgroundFill
{
    /**
     * Type of the background fill, always “gradient”
     */
    #[EnumOrScalar]
    public BackgroundFillType|string $type = BackgroundFillType::GRADIENT;

    /**
     * Top color of the gradient in the RGB24 format
     */
    public int $top_color;

    /**
     * Bottom color of the gradient in the RGB24 format
     */
    public int $bottom_color;

    /**
     * Clockwise rotation angle of the background fill in degrees; 0-359
     */
    public int $rotation_angle;
}
