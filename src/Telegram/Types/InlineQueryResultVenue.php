<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a venue. By default, the venue will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the venue.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvenue
 */
class InlineQueryResultVenue
{
    /**
     * Type of the result, must be venue
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string
     */
    public string $id;

    /**
     * Latitude of the venue location in degrees
     * @var float
     */
    public float $latitude;

    /**
     * Longitude of the venue location in degrees
     * @var float
     */
    public float $longitude;

    /**
     * Title of the venue
     * @var string
     */
    public string $title;

    /**
     * Address of the venue
     * @var string
     */
    public string $address;

    /**
     * Optional. Foursquare identifier of the venue if known
     * @var string
     */
    public string $foursquare_id;

    /**
     * $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @var string
     */
    public string $foursquare_type;

    /**
     * Optional. Google Places identifier of the venue
     * @var string
     */
    public string $google_place_id;

    /**
     * Optional. Google Places type of the venue.
     * (See {@see https://developers.google.com/places/web-service/supported_types supported types}.)
     * @var string
     */
    public string $google_place_type;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the venue
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
