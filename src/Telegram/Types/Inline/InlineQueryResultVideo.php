<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputInvoiceMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a link to a page containing an embedded video player or a video file.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the video.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvideo
 */
class InlineQueryResultVideo extends InlineQueryResult
{
    /** Type of the result, must be video */
    public string $type;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid URL for the embedded video player or video file */
    public string $video_url;

    /** MIME type of the content of the video URL, “text/html” or “video/mp4” */
    public string $mime_type;

    /** URL of the thumbnail (JPEG only) for the video */
    public string $thumbnail_url;

    /** Title for the result */
    public string $title;

    /**
     * Optional.
     * Caption of the video to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the video caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ?ParseMode $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional.
     * Video width
     */
    public ?int $video_width = null;

    /**
     * Optional.
     * Video height
     */
    public ?int $video_height = null;

    /**
     * Optional.
     * Video duration in seconds
     */
    public ?int $video_duration = null;

    /**
     * Optional.
     * Short description of the result
     */
    public ?string $description = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the video.
     * This field is required if InlineQueryResultVideo is used to send an HTML-page as a result (e.g., a YouTube video).
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|InputInvoiceMessageContent|null $input_message_content = null;
}
