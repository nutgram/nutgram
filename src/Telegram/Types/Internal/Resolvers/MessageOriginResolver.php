<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\MessageOriginType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOrigin;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginChannel;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginChat;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginHiddenUser;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginUser;

#[Attribute(Attribute::TARGET_CLASS)]
class MessageOriginResolver extends ConcreteResolver
{
    protected array $concretes = [
        MessageOriginType::USER->value => MessageOriginUser::class,
        MessageOriginType::HIDDEN_USER->value => MessageOriginHiddenUser::class,
        MessageOriginType::CHAT->value => MessageOriginChat::class,
        MessageOriginType::CHANNEL->value => MessageOriginChannel::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends MessageOrigin {
        })::class;
    }
}
