<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

/**
 * This object represents a point on the map.
 * @see https://core.telegram.org/bots/api#location
 */
class Location
{
    /**
     * Longitude as defined by sender
     * @var double $longitude
     */
    public $longitude;

    /**
     * Latitude as defined by sender
     * @var double $latitude
     */
    public $latitude;

    /**
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     * @var double $horizontal_accuracy
     */
    public $horizontal_accuracy;

    /**
     * Optional. Time relative to the message sending date, during which the location can be updated, in seconds.
     * For active live locations only.
     * @var int $live_period
     */
    public $live_period;

    /**
     * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
     * @var int $heading
     */
    public $heading;

    /**
     * Optional. Maximum distance for proximity alerts about approaching another chat member, in meters.
     * For sent live locations only.
     * @var int $proximity_alert_radius
     */
    public $proximity_alert_radius;
}
