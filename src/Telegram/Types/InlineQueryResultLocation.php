<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a location on a map. By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the location.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation
{
    /**
     * Type of the result, must be location
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string
     */
    public string $id;

    /**
     * Location latitude in degrees
     * @var float
     */
    public float $latitude;

    /**
     * Location longitude in degrees
     * @var float
     */
    public float $longitude;

    /**
     * Location title
     * @var string
     */
    public string $title;

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

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the location
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     * @var string
     */
    public string $thumb_url;

    /**
     * Optional. Thumbnail width
     * @var int
     */
    public int $thumb_width;

    /**
     * Optional. Thumbnail height
     * @var int
     */
    public int $thumb_height;
}
