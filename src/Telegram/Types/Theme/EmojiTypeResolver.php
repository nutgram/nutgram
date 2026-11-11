<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\EmojiTypeEmojiType;

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
