<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     * @var string $id
     */
    public $id;

    /**
     * Latitude of the venue location in degrees
     * @var double $latitude
     */
    public $latitude;

    /**
     * Longitude of the venue location in degrees
     * @var double $longitude
     */
    public $longitude;

    /**
     * Title of the venue
     * @var string $title
     */
    public $title;

    /**
     * Address of the venue
     * @var string $address
     */
    public $address;

    /**
     * Optional. Foursquare identifier of the venue if known
     * @var string $foursquare_id
     */
    public $foursquare_id;

    /**
     * $foursquare_type Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @var string $foursquare_type
     */
    public $foursquare_type;

    /**
     * Optional. Google Places identifier of the venue
     * @var string $google_place_id
     */
    public $google_place_id;

    /**
     * Optional. Google Places type of the venue.
     * (See {@see https://developers.google.com/places/web-service/supported_types supported types}.)
     * @var string $google_place_type
     */
    public $google_place_type;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the venue
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     * @var string $thumb_url
     */
    public $thumb_url;

    /**
     * Optional. Thumbnail width
     * @var int $thumb_width
     */
    public $thumb_width;

    /**
     * Optional. Thumbnail height
     * @var int $thumb_height
     */
    public $thumb_height;
}
