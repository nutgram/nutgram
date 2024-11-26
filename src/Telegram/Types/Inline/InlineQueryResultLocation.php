<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a location on a map.
 * By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the location.
 * @see https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation extends InlineQueryResult
{
    /** Type of the result, must be location */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::LOCATION;

    /** Unique identifier for this result, 1-64 Bytes */
    public string $id;

    /** Location latitude in degrees */
    public float $latitude;

    /** Location longitude in degrees */
    public float $longitude;

    /** Location title */
    public string $title;

    /**
     * Optional.
     * The radius of uncertainty for the location, measured in meters;
     * 0-1500
     */
    public ?float $horizontal_accuracy = null;

    /**
     * Optional. Period in seconds during which the location can be updated, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely.
     */
    public ?int $live_period = null;

    /**
     * Optional.
     * For live locations, a direction in which the user is moving, in degrees.
     * Must be between 1 and 360 if specified.
     */
    public ?int $heading = null;

    /**
     * Optional.
     * For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters.
     * Must be between 1 and 100000 if specified.
     */
    public ?int $proximity_alert_radius = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the location
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
        ?float $horizontal_accuracy = null,
        ?int $live_period = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
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
        $this->horizontal_accuracy = $horizontal_accuracy;
        $this->live_period = $live_period;
        $this->heading = $heading;
        $this->proximity_alert_radius = $proximity_alert_radius;
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
        ?float $horizontal_accuracy = null,
        ?int $live_period = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
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
            horizontal_accuracy: $horizontal_accuracy,
            live_period: $live_period,
            heading: $heading,
            proximity_alert_radius: $proximity_alert_radius,
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
            'horizontal_accuracy' => $this->horizontal_accuracy,
            'live_period' => $this->live_period,
            'heading' => $this->heading,
            'proximity_alert_radius' => $this->proximity_alert_radius,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'thumb_url' => $this->thumbnail_url,
            'thumb_width' => $this->thumbnail_width,
            'thumb_height' => $this->thumbnail_height,
        ]);
    }
}
