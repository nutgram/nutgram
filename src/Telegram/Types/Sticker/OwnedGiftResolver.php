<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\OwnedGiftType;

#[Attribute(Attribute::TARGET_CLASS)]
class OwnedGiftResolver extends ConcreteResolver
{
    protected array $concretes = [
        OwnedGiftType::REGULAR->value => OwnedGiftRegular::class,
        OwnedGiftType::UNIQUE->value => OwnedGiftUnique::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends OwnedGift {
        })::class;
    }
}
