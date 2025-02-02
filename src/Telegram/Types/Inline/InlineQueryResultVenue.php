<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a venue.
 * By default, the venue will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the venue.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvenue
 */
class InlineQueryResultVenue extends InlineQueryResult
{
    /** Type of the result, must be venue */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::VENUE;

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

    public function __construct(
        string $id,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->title = $title;
        $this->address = $address;
        $this->foursquare_id = $foursquare_id;
        $this->foursquare_type = $foursquare_type;
        $this->google_place_id = $google_place_id;
        $this->google_place_type = $google_place_type;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->thumbnail_url = $thumbnail_url;
        $this->thumbnail_width = $thumbnail_width;
        $this->thumbnail_height = $thumbnail_height;
    }

    public static function make(
        string $id,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ): self {
        return new self(
            id: $id,
            latitude: $latitude,
            longitude: $longitude,
            title: $title,
            address: $address,
            foursquare_id: $foursquare_id,
            foursquare_type: $foursquare_type,
            google_place_id: $google_place_id,
            google_place_type: $google_place_type,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
            thumbnail_url: $thumbnail_url,
            thumbnail_width: $thumbnail_width,
            thumbnail_height: $thumbnail_height,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'title' => $this->title,
            'address' => $this->address,
            'foursquare_id' => $this->foursquare_id,
            'foursquare_type' => $this->foursquare_type,
            'google_place_id' => $this->google_place_id,
            'google_place_type' => $this->google_place_type,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'thumb_url' => $this->thumbnail_url,
            'thumb_width' => $this->thumbnail_width,
            'thumb_height' => $this->thumbnail_height,
        ]);
    }
}
