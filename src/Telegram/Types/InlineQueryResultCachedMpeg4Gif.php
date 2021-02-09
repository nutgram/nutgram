<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound) stored on the Telegram servers.
 * By default, this animated MPEG-4 file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the
 * animation.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedmpeg4gif
 */
class InlineQueryResultCachedMpeg4Gif
{
    /**
     * Type of the result, must be mpeg4_gif
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;

    /**
     * A valid file identifier for the MP4 file
     * @var string
     */
    public string $mpeg4_file_id;

    /**
     * Optional. Title for the result
     * @var string
     */
    public string $title;

    /**
     * Optional. Caption of the MPEG-4 file to be sent, 0-1024 characters
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
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the video animation
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
