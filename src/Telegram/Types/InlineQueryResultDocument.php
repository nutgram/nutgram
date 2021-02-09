<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a file. By default, this file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the file.
 * Currently, only .PDF and .ZIP files can be sent using this method.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultdocument
 */
class InlineQueryResultDocument
{
    /**
     * Type of the result, must be document
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;

    /**
     * Title for the result
     * @var string
     */
    public string $title;

    /**
     * Optional. Caption of the document to be sent, 0-1024 characters
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
     * A valid URL for the file
     * @var string
     */
    public string $document_url;

    /**
     * Mime type of the content of the file, either “application/pdf” or “application/zip”
     * @var string
     */
    public string $mime_type;

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
     * Optional. Content of the message to be sent instead of the file
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;

    /**
     * Optional. URL of the thumbnail (jpeg only) for the file
     * @var string
     */
    public string $thumb_url;

    /**
     * Optional. Thumbnail width
     * @var int
     */
    public int $thumb_width;

    /**
     * Optional. Thumbnail height
     * @var int
     */
    public int $thumb_height;
}
