<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a point on the map.
 * @see https://core.telegram.org/bots/api#location
 */
class Location extends BaseType
{
    /** Longitude as defined by sender */
    public float $longitude;

    /** Latitude as defined by sender */
    public float $latitude;

    /**
     * Optional.
     * The radius of uncertainty for the location, measured in meters;
     * 0-1500
     */
    public ?float $horizontal_accuracy = null;

    /**
     * Optional.
     * Time relative to the message sending date, during which the location can be updated;
     * in seconds.
     * For active live locations only.
     */
    public ?int $live_period = null;

    /**
     * Optional.
     * The direction in which user is moving, in degrees;
     * 1-360.
     * For active live locations only.
     */
    public ?int $heading = null;

    /**
     * Optional.
     * The maximum distance for proximity alerts about approaching another chat member, in meters.
     * For sent live locations only.
     */
    public ?int $proximity_alert_radius = null;
}
