<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

#[Attribute(Attribute::TARGET_CLASS)]
class ReactionTypeResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            ReactionTypeType::EMOJI->value => ReactionTypeEmoji::class,
            ReactionTypeType::CUSTOM_EMOJI->value => ReactionTypeCustomEmoji::class,
            default => (new class extends ReactionType {
            })::class,
        };
    }
}
