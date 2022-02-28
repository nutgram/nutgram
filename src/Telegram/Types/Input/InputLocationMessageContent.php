<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a location message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputlocationmessagecontent
 */
class InputLocationMessageContent extends BaseType
{
    /**
     * Latitude of the location in degrees
     */
    public float $latitude;

    /**
     * Longitude of the location in degrees
     */
    public float $longitude;

    /**
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     */
    public ?float $horizontal_accuracy = null;

    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     */
    public ?int $live_period = null;

    /**
     * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
     */
    public ?int $heading = null;

    /**
     * Optional. For live locations, a maximum distance for proximity alerts
     * about approaching another chat member, in meters.
     * Must be between 1 and 100000 if specified.
     */
    public ?int $proximity_alert_radius = null;
}
