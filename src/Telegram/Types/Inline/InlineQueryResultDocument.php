<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\Alias;
use SergiX44\Hydrator\Annotation\ArrayType;
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
class InlineQueryResultDocument extends InlineQueryResult
{
    /**
     * Type of the result, must be document
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     */
    public string $id;

    /**
     * Title for the result
     */
    public string $title;

    /**
     * Optional. Caption of the document to be sent, 0-1024 characters
     */
    public ?string $caption = null;

    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     */
    public ?string $parse_mode = null;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var \SergiX44\Nutgram\Telegram\Types\Message\MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * A valid URL for the file
     */
    public string $document_url;

    /**
     * Mime type of the content of the file, either “application/pdf” or “application/zip”
     */
    public string $mime_type;

    /**
     * Optional. Short description of the result
     */
    public ?string $description = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional. Content of the message to be sent instead of the file
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|null $input_message_content;

    /**
     * Optional. URL of the thumbnail (jpeg only) for the file
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional. Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional. Thumbnail height
     */
    public ?int $thumbnail_height = null;

    /**
     * Optional. Url of the thumbnail for the result
     * @deprecated Use thumbnail_url
     */
    #[Alias('thumbnail_url')]
    public ?string $thumb_url = null;

    /**
     * Optional. Thumbnail width
     * @deprecated Use thumbnail_width
     */
    #[Alias('thumbnail_width')]
    public ?int $thumb_width = null;

    /**
     * Optional. Thumbnail height
     * @deprecated Use thumbnail_height
     */
    #[Alias('thumbnail_height')]
    public ?int $thumb_height = null;
}
