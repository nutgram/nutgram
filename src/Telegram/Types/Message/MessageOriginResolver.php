<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;

#[Attribute(Attribute::TARGET_CLASS)]
class MessageOriginResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            MessageOriginType::USER->value => MessageOriginUser::class,
            MessageOriginType::HIDDEN_USER->value => MessageOriginHiddenUser::class,
            MessageOriginType::CHAT->value => MessageOriginChat::class,
            MessageOriginType::CHANNEL->value => MessageOriginChannel::class,
            default => (new class extends MessageOrigin {
            })::class,
        };
    }
}
