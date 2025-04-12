<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a story area pointing to a unique gift. Currently, a story can have at most 1 unique gift area.
 * @see https://core.telegram.org/bots/api#storyareatypeuniquegift
 */
class StoryAreaTypeUniqueGift extends BaseType
{
    /**
     * Type of the area, always “unique_gift”
     */
    #[EnumOrScalar]
    public StoryAreaTypeType|string $type = StoryAreaTypeType::UNIQUE_GIFT;

    /**
     * Unique name of the gift
     */
    public string $name;
}
