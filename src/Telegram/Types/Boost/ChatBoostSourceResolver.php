<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatBoostSourceResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['source'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            ChatBoostSourceSource::PREMIUM->value => ChatBoostSourcePremium::class,
            ChatBoostSourceSource::GIFT_CODE->value => ChatBoostSourceGiftCode::class,
            ChatBoostSourceSource::GIVEAWAY->value => ChatBoostSourceGiveaway::class,
            default => (new class extends ChatBoostSource {
            })::class,
        };
    }
}
