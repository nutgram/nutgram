<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;

/**
 * Describes a story area containing weather information. Currently, a story can have up to 3 weather areas.
 * @see https://core.telegram.org/bots/api#storyareatypeweather
 */
#[SkipConstructor]
class StoryAreaTypeWeather extends StoryAreaType
{
    /**
     * Type of the area, always “weather”
     */
    #[EnumOrScalar]
    public StoryAreaTypeType|string $type = StoryAreaTypeType::WEATHER;

    /**
     * Temperature, in degree Celsius
     */
    public float $temperature;

    /**
     * Emoji representing the weather
     */
    public string $emoji;

    /**
     * A color of the area background in the ARGB format
     */
    public int $background_color;

    public function __construct(
        float $temperature,
        string $emoji,
        int $background_color
    ) {
        parent::__construct();
        $this->temperature = $temperature;
        $this->emoji = $emoji;
        $this->background_color = $background_color;
    }
}
