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
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;

    /**
     * A valid URL for the embedded video player or video file
     * @var string
     */
    public string $video_url;

    /**
     * Mime type of the content of video url, “text/html” or “video/mp4”
     * @var string
     */
    public string $mime_type;

    /**
     * URL of the thumbnail (jpeg only) for the video
     * @var string
     */
    public string $thumb_url;

    /**
     * Title for the result
     * @var string
     */
    public string $title;

    /**
     * Optional. Caption of the video to be sent, 0-1024 characters
     * @var string
     */
    public string $caption;

    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     * @var string
     */
    public string $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[]
     */
    public array $caption_entities;

    /**
     * Optional. Video width
     * @var int
     */
    public int $video_width;

    /**
     * Optional. Video height
     * @var int
     */
    public int $video_height;

    /**
     * Optional. Video duration in seconds
     * @var int
     */
    public int $video_duration;

    /**
     * Optional. Short description of the result
     * @var string
     */
    public string $description;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the video.
     * This field is required if InlineQueryResultVideo is used to send
     * an HTML-page as a result (e.g., a YouTube video).
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
