<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;

#[Attribute(Attribute::TARGET_CLASS)]
class MaybeInaccessibleMessageResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $date = $data['date'] ?? throw new InvalidArgumentException('Type must be defined');

        if ($date === 0) {
            return InaccessibleMessage::class;
        }

        return Message::class;
    }
}
