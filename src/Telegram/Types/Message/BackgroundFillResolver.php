<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use Attribute;
use InvalidArgumentException;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;

#[Attribute(Attribute::TARGET_CLASS)]
class BackgroundFillResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            BackgroundFillType::SOLID->value => BackgroundFillSolid::class,
            BackgroundFillType::GRADIENT->value => BackgroundFillGradient::class,
            BackgroundFillType::FREEFORM_GRADIENT->value => BackgroundFillFreeformGradient::class,
            default => (new class extends BackgroundFill {
            })::class,
        };
    }
}
