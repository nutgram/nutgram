<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\Alias;
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
class InlineQueryResultVenue extends InlineQueryResult
{
    /**
     * Type of the result, must be venue
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     */
    public string $id;

    /**
     * Latitude of the venue location in degrees
     */
    public float $latitude;

    /**
     * Longitude of the venue location in degrees
     */
    public float $longitude;

    /**
     * Title of the venue
     */
    public string $title;

    /**
     * Address of the venue
     */
    public string $address;

    /**
     * Optional. Foursquare identifier of the venue if known
     */
    public ?string $foursquare_id = null;

    /**
     * Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”,
     * “arts_entertainment/aquarium” or “food/icecream”.)
     */
    public ?string $foursquare_type = null;

    /**
     * Optional. Google Places identifier of the venue
     */
    public ?string $google_place_id = null;

    /**
     * Optional. Google Places type of the venue.
     * (See {@see https://developers.google.com/places/web-service/supported_types supported types}.)
     */
    public ?string $google_place_type = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional. Content of the message to be sent instead of the venue
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|null $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional. Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional. Thumbnail height
     */
    public ?int $thumbnail_height = null;

    /**
     * Optional. Url of the thumbnail for the result
     * @deprecated Use thumbnail_url
     */
    #[Alias('thumbnail_url')]
    public ?string $thumb_url = null;

    /**
     * Optional. Thumbnail width
     * @deprecated Use thumbnail_width
     */
    #[Alias('thumbnail_width')]
    public ?int $thumb_width = null;

    /**
     * Optional. Thumbnail height
     * @deprecated Use thumbnail_height
     */
    #[Alias('thumbnail_height')]
    public ?int $thumb_height = null;
}
