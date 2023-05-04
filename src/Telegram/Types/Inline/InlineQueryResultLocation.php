<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputInvoiceMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a location on a map.
 * By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the location.
 * @see https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation extends InlineQueryResult
{
    /** Type of the result, must be location */
    public string $type;

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
     * Optional.
     * Period in seconds for which the location can be updated, should be between 60 and 86400.
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
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|InputInvoiceMessageContent|null $input_message_content = null;

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
