<?php

namespace SergiX44\Nutgram\Telegram\Types\Location;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a venue.
 * @see https://core.telegram.org/bots/api#venue
 */
class Venue extends BaseType
{
    /**
     * Venue location.
     * Can't be a live location
     */
    public Location $location;

    /** Name of the venue */
    public string $title;

    /** Address of the venue */
    public string $address;

    /**
     * Optional.
     * Foursquare identifier of the venue
     */
    public ?string $foursquare_id = null;

    /**
     * Optional.
     * Foursquare type of the venue.
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
}
