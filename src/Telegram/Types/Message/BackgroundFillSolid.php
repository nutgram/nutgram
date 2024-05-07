<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;

/**
 * The background is filled using the selected color.
 * @see https://core.telegram.org/bots/api#backgroundfillsolid
 */
class BackgroundFillSolid extends BackgroundFill
{
    /**
     * Type of the background fill, always “solid”
     */
    #[EnumOrScalar]
    public BackgroundFillType|string $type = BackgroundFillType::SOLID;

    /**
     * The color of the background fill in the RGB24 format
     */
    public int $color;
}
