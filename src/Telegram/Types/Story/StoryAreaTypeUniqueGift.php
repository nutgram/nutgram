<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;

/**
 * Describes a story area pointing to a unique gift. Currently, a story can have at most 1 unique gift area.
 * @see https://core.telegram.org/bots/api#storyareatypeuniquegift
 */
#[SkipConstructor]
class StoryAreaTypeUniqueGift extends StoryAreaType
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

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }
}
