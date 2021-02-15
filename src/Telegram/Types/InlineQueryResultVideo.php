<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a page containing an embedded video player or a video file.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the video.
 *
 * If an InlineQueryResultVideo message contains an embedded video (e.g., YouTube),
 * you must replace its content using input_message_content.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvideo
 */
class InlineQueryResultVideo
{
    /**
     * Type of the result, must be video
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string $id
     */
    public $id;

    /**
     * A valid URL for the embedded video player or video file
     * @var string $video_url
     */
    public $video_url;

    /**
     * Mime type of the content of video url, “text/html” or “video/mp4”
     * @var string $mime_type
     */
    public $mime_type;

    /**
     * URL of the thumbnail (jpeg only) for the video
     * @var string $thumb_url
     */
    public $thumb_url;

    /**
     * Title for the result
     * @var string $title
     */
    public $title;

    /**
     * Optional. Caption of the video to be sent, 0-1024 characters
     * @var string $caption
     */
    public $caption;

    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     * @var string $parse_mode
     */
    public $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    public $caption_entities;

    /**
     * Optional. Video width
     * @var int $video_width
     */
    public $video_width;

    /**
     * Optional. Video height
     * @var int $video_height
     */
    public $video_height;

    /**
     * Optional. Video duration in seconds
     * @var int $video_duration
     */
    public $video_duration;

    /**
     * Optional. Short description of the result
     * @var string $description
     */
    public $description;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the video.
     * This field is required if InlineQueryResultVideo is used to send
     * an HTML-page as a result (e.g., a YouTube video).
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;
}
