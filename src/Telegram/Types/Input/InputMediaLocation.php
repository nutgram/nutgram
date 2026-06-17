<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a location to be sent.
 * @see https://core.telegram.org/bots/api#inputmedialocation
 */
#[SkipConstructor]
class InputMediaLocation extends BaseType implements InputPollMedia, InputPollOptionMedia, JsonSerializable
{
    /**
     * Type of the result, must be location
     */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::LOCATION;

    /**
     * Latitude of the location
     */
    public float $latitude;

    /**
     * Longitude of the location
     */
    public float $longitude;

    /**
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     */
    public ?float $horizontal_accuracy = null;

    public function __construct(float $latitude, float $longitude, ?float $horizontal_accuracy = null)
    {
        parent::__construct();
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->horizontal_accuracy = $horizontal_accuracy;
    }

    public static function make(float $latitude, float $longitude, ?float $horizontal_accuracy = null): self
    {
        return new self(
            latitude: $latitude,
            longitude: $longitude,
            horizontal_accuracy: $horizontal_accuracy,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'horizontal_accuracy' => $this->horizontal_accuracy,
        ]);
    }
}
