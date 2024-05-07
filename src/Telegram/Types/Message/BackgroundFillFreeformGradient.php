<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;

class BackgroundFillFreeformGradient extends BackgroundFill
{
    /**
     * Type of the background fill, always “freeform_gradient”
     */
    #[EnumOrScalar]
    public BackgroundFillType|string $type = BackgroundFillType::FREEFORM_GRADIENT;

    /**
     * A list of the 3 or 4 base colors that are used to generate the freeform gradient in the RGB24 format
     * @var int[]
     */
    public array $colors;
}
