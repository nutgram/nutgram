<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a venue.
 * By default, the venue will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the venue.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvenue
 */
class InlineQueryResultVenue extends InlineQueryResult
{
    /** Type of the result, must be venue */
    public string $type;

    /** Unique identifier for this result, 1-64 Bytes */
    public string $id;

    /** Latitude of the venue location in degrees */
    public float $latitude;

    /** Longitude of the venue location in degrees */
    public float $longitude;

    /** Title of the venue */
    public string $title;

    /** Address of the venue */
    public string $address;

    /**
     * Optional.
     * Foursquare identifier of the venue if known
     */
    public ?string $foursquare_id = null;

    /**
     * Optional.
     * Foursquare type of the venue, if known.
     * (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     */
    public ?string $foursquare_type = null;

    /**
     * Optional.
     * Google Places identifier of the venue
     */
    public ?string $google_place_id = null;

    /**
     * Optional.
     * Google Places type of the venue.
     * (See {@see https://developers.google.com/places/web-service/supported_types supported types}.)
     */
    public ?string $google_place_type = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the venue
     */
    public ?InputMessageContent $input_message_content = null;

    /**
     * Optional.
     * Url of the thumbnail for the result
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional.
     * Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional.
     * Thumbnail height
     */
    public ?int $thumbnail_height = null;
}
