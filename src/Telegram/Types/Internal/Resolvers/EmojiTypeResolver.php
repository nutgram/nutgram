<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\EmojiTypeEmojiType;
use SergiX44\Nutgram\Telegram\Types\Theme\EmojiType;
use SergiX44\Nutgram\Telegram\Types\Theme\EmojiTypeCustomEmoji;
use SergiX44\Nutgram\Telegram\Types\Theme\EmojiTypeEmoji;

#[Attribute(Attribute::TARGET_CLASS)]
class EmojiTypeResolver extends ConcreteResolver
{
    protected array $concretes = [
        EmojiTypeEmojiType::EMOJI->value => EmojiTypeEmoji::class,
        EmojiTypeEmojiType::CUSTOM_EMOJI->value => EmojiTypeCustomEmoji::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class implements EmojiType {
        })::class;
    }
}
