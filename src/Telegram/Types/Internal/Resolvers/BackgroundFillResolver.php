<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\BackgroundFillType;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFill;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillFreeformGradient;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillGradient;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillSolid;

#[Attribute(Attribute::TARGET_CLASS)]
class BackgroundFillResolver extends ConcreteResolver
{
    protected array $concretes = [
        BackgroundFillType::SOLID->value => BackgroundFillSolid::class,
        BackgroundFillType::GRADIENT->value => BackgroundFillGradient::class,
        BackgroundFillType::FREEFORM_GRADIENT->value => BackgroundFillFreeformGradient::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends BackgroundFill {
        })::class;
    }
}
