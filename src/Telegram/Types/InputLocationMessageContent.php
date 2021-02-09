<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a location message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputlocationmessagecontent
 */
class InputLocationMessageContent
{
    /**
     * Latitude of the location in degrees
     * @var float
     */
    public float $latitude;
    
    /**
     * Longitude of the location in degrees
     * @var float
     */
    public float $longitude;

    /**
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     * @var float
     */
    public float $horizontal_accuracy;

    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     * @var int
     */
    public int $live_period;

    /**
     * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
     * @var int
     */
    public int $heading;

    /**
     * Optional. For live locations, a maximum distance for proximity alerts
     * about approaching another chat member, in meters.
     * Must be between 1 and 100000 if specified.
     * @var int
     */
    public int $proximity_alert_radius;
}
