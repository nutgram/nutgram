<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the way a background is filled based on the selected colors. Currently, it can be one of
 * - {@see BackgroundFillSolid}
 * - {@see BackgroundFillGradient}
 * - {@see BackgroundFillFreeformGradient}
 * @see https://core.telegram.org/bots/api#backgroundfill
 */
#[BackgroundFillResolver]
abstract class BackgroundFill extends BaseType
{
    /**
     * Type of the background fill
     */
    #[EnumOrScalar]
    public BackgroundFillType|string $type;
}
