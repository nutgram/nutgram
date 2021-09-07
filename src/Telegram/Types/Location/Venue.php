<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

/**
 * This object represents a venue.
 * @see https://core.telegram.org/bots/api#venue
 */
class Venue
{
    /**
     * Venue location
     * @var Location $location
     */
    public $location;

    /**
     * Name of the venue
     * @var string $title
     */
    public $title;

    /**
     * Address of the venue
     * @var string $address
     */
    public $address;

    /**
     * Optional. Foursquare identifier of the venue
     * @var string $foursquare_id
     */
    public $foursquare_id;

    /**
     * Optional. Foursquare type of the venue.
     * (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
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
}
