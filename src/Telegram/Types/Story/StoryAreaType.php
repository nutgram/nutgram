<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the type of a clickable area on a story. Currently, it can be one of
 * - {@see StoryAreaTypeLocation}
 * - {@see StoryAreaTypeSuggestedReaction}
 * - {@see StoryAreaTypeLink}
 * - {@see StoryAreaTypeWeather}
 * - {@see StoryAreaTypeUniqueGift}
 */
abstract class StoryAreaType extends BaseType implements JsonSerializable
{
    #[EnumOrScalar]
    public StoryAreaTypeType|string $type;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
