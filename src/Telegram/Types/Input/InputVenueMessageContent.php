<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a venue message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputvenuemessagecontent
 */
class InputVenueMessageContent extends BaseType
{
    /**
     * Latitude of the venue in degrees
     */
    public float $latitude;

    /**
     * Longitude of the venue in degrees
     */
    public float $longitude;

    /**
     * Name of the venue
     */
    public string $title;

    /**
     * Address of the venue
     */
    public string $address;

    /**
     * Optional. Foursquare identifier of the venue, if known
     */
    public ?string $foursquare_id = null;

    /**
     * Optional. Foursquare type of the venue.
     * (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
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
}
