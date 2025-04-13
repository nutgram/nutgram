<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\Location\LocationAddress;

/**
 * Describes a story area pointing to a location. Currently, a story can have up to 10 location areas.
 * @see https://core.telegram.org/bots/api#storyareatypelocation
 */
class StoryAreaTypeLocation extends StoryAreaType
{
    /**
     * Type of the area, always “location”
     */
    #[EnumOrScalar]
    public StoryAreaTypeType|string $type = StoryAreaTypeType::LOCATION;

    /**
     * Location latitude in degrees
     */
    public float $latitude;

    /**
     * Location longitude in degrees
     */
    public float $longitude;

    /**
     * Optional. Address of the location
     */
    public ?LocationAddress $address = null;
}
