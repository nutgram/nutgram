<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSource;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourceGiftCode;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourceGiveaway;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourcePremium;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatBoostSourceResolver extends ConcreteResolver
{
    protected array $concretes = [
        ChatBoostSourceSource::PREMIUM->value => ChatBoostSourcePremium::class,
        ChatBoostSourceSource::GIFT_CODE->value => ChatBoostSourceGiftCode::class,
        ChatBoostSourceSource::GIVEAWAY->value => ChatBoostSourceGiveaway::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['source'] ?? throw new InvalidArgumentException('Source must be defined');
        return $this->concretes[$type] ?? (new class extends ChatBoostSource {
        })::class;
    }
}
