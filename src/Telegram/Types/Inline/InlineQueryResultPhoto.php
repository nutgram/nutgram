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
 * Represents a link to a photo. By default, this photo will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the photo.
 * @see https://core.telegram.org/bots/api#inlinequeryresultphoto
 */
class InlineQueryResultPhoto extends InlineQueryResult
{
    /**
     * Type of the result, must be photo
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     */
    public string $id;

    /**
     * A valid URL of the photo. Photo must be in jpeg format. Photo size must not exceed 5MB
     */
    public string $photo_url;

    /**
     * URL of the thumbnail for the photo
     */
    public string $thumbnail_url;

    /**
     * URL of the thumbnail for the photo
     * @deprecated use thumbnail_url
     */
    #[Alias('thumbnail_url')]
    public ?string $thumb_url;

    /**
     * Optional. Width of the photo
     */
    public ?int $photo_width = null;

    /**
     * Optional. Height of the photo
     */
    public ?int $photo_height = null;

    /**
     * Optional. Title for the result
     */
    public ?string $title = null;

    /**
     * Optional. Short description of the result
     */
    public ?string $description = null;

    /**
     * Optional. Caption of the photo to be sent, 0-1024 characters
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
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional. Content of the message to be sent instead of the photo
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|null $input_message_content;
}
