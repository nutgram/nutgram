<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * Represents a location to be sent.
 * @see https://core.telegram.org/bots/api#inputmedialocation
 */
#[OverrideConstructor('bindToInstance')]
class InputMediaLocation extends BaseType implements InputPollMedia, InputPollOptionMedia
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
}
