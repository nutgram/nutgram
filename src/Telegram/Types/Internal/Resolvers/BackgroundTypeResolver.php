<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundType;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypeChatTheme;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypeFill;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypePattern;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypeWallpaper;

#[Attribute(Attribute::TARGET_CLASS)]
class BackgroundTypeResolver extends ConcreteResolver
{
    protected array $concretes = [
        BackgroundTypeType::FILL->value => BackgroundTypeFill::class,
        BackgroundTypeType::WALLPAPER->value => BackgroundTypeWallpaper::class,
        BackgroundTypeType::PATTERN->value => BackgroundTypePattern::class,
        BackgroundTypeType::CHAT_THEME->value => BackgroundTypeChatTheme::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends BackgroundType {
        })::class;
    }
}
