<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a location message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputlocationmessagecontent
 */
#[OverrideConstructor('bindToInstance')]
class InputLocationMessageContent extends InputMessageContent
{
    /** Latitude of the location in degrees */
    public float $latitude;

    /** Longitude of the location in degrees */
    public float $longitude;

    /**
     * Optional.
     * The radius of uncertainty for the location, measured in meters;
     * 0-1500
     */
    public ?float $horizontal_accuracy = null;

    /**
     * Optional. Period in seconds during which the location can be updated, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely.
     */
    public ?int $live_period = null;

    /**
     * Optional.
     * For live locations, a direction in which the user is moving, in degrees.
     * Must be between 1 and 360 if specified.
     */
    public ?int $heading = null;

    /**
     * Optional.
     * For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters.
     * Must be between 1 and 100000 if specified.
     */
    public ?int $proximity_alert_radius = null;

    public function __construct(
        float $latitude,
        float $longitude,
        ?float $horizontal_accuracy = null,
        ?int $live_period = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
    ) {
        parent::__construct();
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->horizontal_accuracy = $horizontal_accuracy;
        $this->live_period = $live_period;
        $this->heading = $heading;
        $this->proximity_alert_radius = $proximity_alert_radius;
    }


    public function jsonSerialize(): array
    {
        return array_filter_null([
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'horizontal_accuracy' => $this->horizontal_accuracy,
            'live_period' => $this->live_period,
            'heading' => $this->heading,
            'proximity_alert_radius' => $this->proximity_alert_radius,
        ]);
    }
}
