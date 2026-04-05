<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Types\Message\InaccessibleMessage;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

#[Attribute(Attribute::TARGET_CLASS)]
class MaybeInaccessibleMessageResolver extends ConcreteResolver
{
    protected static array $concreteTypes = [
        Message::class,
        InaccessibleMessage::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        return $data['date'] === 0
            ? InaccessibleMessage::class
            : Message::class;
    }
}
