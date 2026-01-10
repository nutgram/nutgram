<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Internal\Resolvers;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaType;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaTypeLink;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaTypeLocation;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaTypeSuggestedReaction;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaTypeUniqueGift;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaTypeWeather;

#[Attribute(Attribute::TARGET_CLASS)]
class StoryAreaTypeResolver extends ConcreteResolver
{
    protected array $concretes = [
        StoryAreaTypeType::LOCATION->value => StoryAreaTypeLocation::class,
        StoryAreaTypeType::SUGGESTED_REACTION->value => StoryAreaTypeSuggestedReaction::class,
        StoryAreaTypeType::LINK->value => StoryAreaTypeLink::class,
        StoryAreaTypeType::WEATHER->value => StoryAreaTypeWeather::class,
        StoryAreaTypeType::UNIQUE_GIFT->value => StoryAreaTypeUniqueGift::class,
    ];

    public function concreteFor(array $data, array $all): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends StoryAreaType {
        })::class;
    }
}
