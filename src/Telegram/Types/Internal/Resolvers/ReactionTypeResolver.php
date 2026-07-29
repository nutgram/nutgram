<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeCustomEmoji;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeEmoji;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypePaid;

#[Attribute(Attribute::TARGET_CLASS)]
class ReactionTypeResolver extends ConcreteResolver
{
    protected array $concretes = [
        ReactionTypeType::EMOJI->value => ReactionTypeEmoji::class,
        ReactionTypeType::CUSTOM_EMOJI->value => ReactionTypeCustomEmoji::class,
        ReactionTypeType::PAID->value => ReactionTypePaid::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends ReactionType {
        })::class;
    }
}
