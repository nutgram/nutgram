<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a venue to be sent.
 * @see https://core.telegram.org/bots/api#inputmediavenue
 */
#[SkipConstructor]
class InputMediaVenue extends BaseType implements InputPollMedia, InputPollOptionMedia, JsonSerializable
{
    /**
     * Type of the result, must be venue
     */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::VENUE;

    /**
     * Latitude of the location
     */
    public float $latitude;

    /**
     * Longitude of the location
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
     * Optional. Foursquare identifier of the venue
     */
    public ?string $foursquare_id = null;

    /**
     * Optional. Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
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

    public function __construct(
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
    ) {
        parent::__construct();
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->title = $title;
        $this->address = $address;
        $this->foursquare_id = $foursquare_id;
        $this->foursquare_type = $foursquare_type;
        $this->google_place_id = $google_place_id;
        $this->google_place_type = $google_place_type;
    }

    public static function make(
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
    ): self
    {
        return new self(
            latitude: $latitude,
            longitude: $longitude,
            title: $title,
            address: $address,
            foursquare_id: $foursquare_id,
            foursquare_type: $foursquare_type,
            google_place_id: $google_place_id,
            google_place_type: $google_place_type,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
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
