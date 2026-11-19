<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ChatShareThemeType;
use SergiX44\Nutgram\Telegram\Types\Theme\ChatShareTheme;
use SergiX44\Nutgram\Telegram\Types\Theme\ChatShareThemeEmoji;
use SergiX44\Nutgram\Telegram\Types\Theme\ChatShareThemeUniqueGift;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatShareThemeResolver extends ConcreteResolver
{
    protected array $concretes = [
        ChatShareThemeType::EMOJI->value => ChatShareThemeEmoji::class,
        ChatShareThemeType::UNIQUE_GIFT->value => ChatShareThemeUniqueGift::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class implements ChatShareTheme {
        })::class;
    }
}
