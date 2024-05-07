<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;

#[Attribute(Attribute::TARGET_CLASS)]
class BackgroundTypeResolver extends ConcreteResolver
{
    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');

        return match ($type) {
            BackgroundTypeType::FILL->value => BackgroundTypeFill::class,
            BackgroundTypeType::WALLPAPER->value => BackgroundTypeWallpaper::class,
            BackgroundTypeType::PATTERN->value => BackgroundTypePattern::class,
            BackgroundTypeType::CHAT_THEME->value => BackgroundTypeChatTheme::class,
            default => (new class extends BackgroundType {
            })::class,
        };
    }
}
