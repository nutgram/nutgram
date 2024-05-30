<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound).
 * By default, this animated MPEG-4 file will be sent by the user with optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the animation.
 * @see https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 */
class InlineQueryResultMpeg4Gif extends InlineQueryResult
{
    /** Type of the result, must be mpeg4_gif */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::MPEG4_GIF;

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
    #[EnumOrScalar]
    public ParseMode|string|null $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. True, if the caption must be shown above the message media
     */
    public ?bool $show_caption_above_media = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the video animation
     */
    public ?InputMessageContent $input_message_content = null;

    public function __construct(
        string $id,
        string $mpeg4_url,
        string $thumbnail_url,
        ?int $mpeg4_width = null,
        ?int $mpeg4_height = null,
        ?int $mpeg4_duration = null,
        ?string $thumbnail_mime_type = null,
        ?string $title = null,
        ?string $caption = null,
        ?ParseMode $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->mpeg4_url = $mpeg4_url;
        $this->thumbnail_url = $thumbnail_url;
        $this->mpeg4_width = $mpeg4_width;
        $this->mpeg4_height = $mpeg4_height;
        $this->mpeg4_duration = $mpeg4_duration;
        $this->thumbnail_mime_type = $thumbnail_mime_type;
        $this->title = $title;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->show_caption_above_media = $show_caption_above_media;
    }

    public static function make(
        string $id,
        string $mpeg4_url,
        string $thumbnail_url,
        ?int $mpeg4_width = null,
        ?int $mpeg4_height = null,
        ?int $mpeg4_duration = null,
        ?string $thumbnail_mime_type = null,
        ?string $title = null,
        ?string $caption = null,
        ?ParseMode $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ): self {
        return new self(
            id: $id,
            mpeg4_url: $mpeg4_url,
            thumbnail_url: $thumbnail_url,
            mpeg4_width: $mpeg4_width,
            mpeg4_height: $mpeg4_height,
            mpeg4_duration: $mpeg4_duration,
            thumbnail_mime_type: $thumbnail_mime_type,
            title: $title,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
            show_caption_above_media: $show_caption_above_media,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'id' => $this->id,
            'mpeg4_url' => $this->mpeg4_url,
            'mpeg4_width' => $this->mpeg4_width,
            'mpeg4_height' => $this->mpeg4_height,
            'mpeg4_duration' => $this->mpeg4_duration,
            'thumb_url' => $this->thumbnail_url,
            'thumb_mime_type' => $this->thumbnail_mime_type,
            'title' => $this->title,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode?->value,
            'caption_entities' => $this->caption_entities,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'show_caption_above_media' => $this->show_caption_above_media,
        ]);
    }
}
