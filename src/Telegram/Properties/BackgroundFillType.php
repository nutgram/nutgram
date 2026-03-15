<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillFreeformGradient;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillGradient;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillSolid;

enum BackgroundFillType: string
{
    case SOLID = 'solid';
    case GRADIENT = 'gradient';
    case FREEFORM_GRADIENT = 'freeform_gradient';

    public static function resolve(string $type): ?string
    {
        return match ($type) {
            self::SOLID->value => BackgroundFillSolid::class,
            self::GRADIENT->value => BackgroundFillGradient::class,
            self::FREEFORM_GRADIENT->value => BackgroundFillFreeformGradient::class,
            default => null,
        };
    }
}
