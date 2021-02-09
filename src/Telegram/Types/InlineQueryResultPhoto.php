<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a photo. By default, this photo will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the photo.
 * @see https://core.telegram.org/bots/api#inlinequeryresultphoto
 */
class InlineQueryResultPhoto
{
    /**
     * Type of the result, must be photo
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;

    /**
     * A valid URL of the photo. Photo must be in jpeg format. Photo size must not exceed 5MB
     * @var string
     */
    public string $photo_url;

    /**
     * URL of the thumbnail for the photo
     * @var string
     */
    public string $thumb_url;

    /**
     * Optional. Width of the photo
     * @var int
     */
    public int $photo_width;

    /**
     * Optional. Height of the photo
     * @var int
     */
    public int $photo_height;

    /**
     * Optional. Title for the result
     * @var string
     */
    public string $title;

    /**
     * Optional. Short description of the result
     * @var string
     */
    public string $description;

    /**
     * Optional. Caption of the photo to be sent, 0-1024 characters
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
     * Optional. Content of the message to be sent instead of the photo
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
