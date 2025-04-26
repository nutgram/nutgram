<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\Location\LocationAddress;

/**
 * Describes a story area pointing to a location. Currently, a story can have up to 10 location areas.
 * @see https://core.telegram.org/bots/api#storyareatypelocation
 */
#[SkipConstructor]
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

    public function __construct(float $latitude, float $longitude, ?LocationAddress $address = null)
    {
        parent::__construct();
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }
}
