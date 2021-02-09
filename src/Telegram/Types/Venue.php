<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a venue.
 * @see https://core.telegram.org/bots/api#venue
 */
class Venue
{
    /**
     * Venue location
     * @var Location
     */
    public Location $location;
    
    /**
     * Name of the venue
     * @var string
     */
    public string $title;
    
    /**
     * Address of the venue
     * @var string
     */
    public string $address;
    
    /**
     * Optional. Foursquare identifier of the venue
     * @var string
     */
    public string $foursquare_id;
    
    /**
     * Optional. Foursquare type of the venue.
     * (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
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
}
