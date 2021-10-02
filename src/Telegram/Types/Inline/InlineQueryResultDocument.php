<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

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
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string $id
     */
    public $id;

    /**
     * Title for the result
     * @var string $title
     */
    public $title;

    /**
     * Optional. Caption of the document to be sent, 0-1024 characters
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
     * A valid URL for the file
     * @var string $document_url
     */
    public $document_url;

    /**
     * Mime type of the content of the file, either “application/pdf” or “application/zip”
     * @var string $mime_type
     */
    public $mime_type;

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
     * Optional. Content of the message to be sent instead of the file
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;

    /**
     * Optional. URL of the thumbnail (jpeg only) for the file
     * @var string $thumb_url
     */
    public $thumb_url;

    /**
     * Optional. Thumbnail width
     * @var int $thumb_width
     */
    public $thumb_width;

    /**
     * Optional. Thumbnail height
     * @var int $thumb_height
     */
    public $thumb_height;
}
