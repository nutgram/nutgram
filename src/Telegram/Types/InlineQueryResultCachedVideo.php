<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a video file stored on the Telegram servers.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the video.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedvideo
 */
class InlineQueryResultCachedVideo
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
     * A valid file identifier for the video file
     * @var string $video_file_id
     */
    public $video_file_id;
    
    /**
     * Title for the result
     * @var string $title
     */
    public $title;
    
    /**
     * Optional. Short description of the result
     * @var string $description
     */
    public $description;
    
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
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;
    
    /**
     * Optional. Content of the message to be sent instead of the video
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;
}
