<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content} of a venue message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputvenuemessagecontent
 */
class InputVenueMessageContent extends InputMessageContent
{
    /** Latitude of the venue in degrees */
    public float $latitude;

    /** Longitude of the venue in degrees */
    public float $longitude;

    /** Name of the venue */
    public string $title;

    /** Address of the venue */
    public string $address;

    /**
     * Optional.
     * Foursquare identifier of the venue, if known
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


    public static function make(
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
    ): self {
        $instance = new self;
        $instance->latitude = $latitude;
        $instance->longitude = $longitude;
        $instance->title = $title;
        $instance->address = $address;
        $instance->foursquare_id = $foursquare_id;
        $instance->foursquare_type = $foursquare_type;
        $instance->google_place_id = $google_place_id;
        $instance->google_place_type = $google_place_type;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'title' => $this->title,
            'address' => $this->address,
            'foursquare_id' => $this->foursquare_id,
            'foursquare_type' => $this->foursquare_type,
            'google_place_id' => $this->google_place_id,
            'google_place_type' => $this->google_place_type,
        ]);
    }
}
