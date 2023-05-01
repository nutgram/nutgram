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
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound).
 * By default, this animated MPEG-4 file will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the animation.
 * @see https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 */
class InlineQueryResultMpeg4Gif extends InlineQueryResult
{
    /** Type of the result, must be mpeg4_gif */
    public string $type;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /**
     * A valid URL for the MPEG4 file.
     * File size must not exceed 1MB
     */
    public string $mpeg4_url;

    /**
     * Optional.
     * Video width
     */
    public ?int $mpeg4_width = null;

    /**
     * Optional.
     * Video height
     */
    public ?int $mpeg4_height = null;

    /**
     * Optional.
     * Video duration in seconds
     */
    public ?int $mpeg4_duration = null;

    /** URL of the static (JPEG or GIF) or animated (MPEG4) thumbnail for the result */
    public string $thumbnail_url;

    /**
     * Optional.
     * MIME type of the thumbnail, must be one of “image/jpeg”, “image/gif”, or “video/mp4”.
     * Defaults to “image/jpeg”
     */
    public ?string $thumbnail_mime_type = null;

    /**
     * Optional.
     * Title for the result
     */
    public ?string $title = null;

    /**
     * Optional.
     * Caption of the MPEG-4 file to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the caption.
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
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the video animation
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|InputInvoiceMessageContent|null $input_message_content = null;
}
