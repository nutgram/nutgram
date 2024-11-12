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
 * Represents a link to a page containing an embedded video player or a video file.
 * By default, this video file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the video.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvideo
 */
class InlineQueryResultVideo extends InlineQueryResult
{
    /** Type of the result, must be video */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::VIDEO;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid URL for the embedded video player or video file */
    public string $video_url;

    /** MIME type of the content of the video URL, “text/html” or “video/mp4” */
    public string $mime_type;

    /** URL of the thumbnail (JPEG only) for the video */
    public string $thumbnail_url;

    /** Title for the result */
    public string $title;

    /**
     * Optional.
     * Caption of the video to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the video caption.
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
     * Optional.
     * Video width
     */
    public ?int $video_width = null;

    /**
     * Optional.
     * Video height
     */
    public ?int $video_height = null;

    /**
     * Optional.
     * Video duration in seconds
     */
    public ?int $video_duration = null;

    /**
     * Optional.
     * Short description of the result
     */
    public ?string $description = null;

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
     * Content of the message to be sent instead of the video.
     * This field is required if InlineQueryResultVideo is used to send an HTML-page as a result (e.g., a YouTube video).
     */
    public ?InputMessageContent $input_message_content = null;

    public function __construct(
        string $id,
        string $video_url,
        string $mime_type,
        string $thumbnail_url,
        string $title,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?int $video_width = null,
        ?int $video_height = null,
        ?int $video_duration = null,
        ?string $description = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->video_url = $video_url;
        $this->mime_type = $mime_type;
        $this->thumbnail_url = $thumbnail_url;
        $this->title = $title;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->video_width = $video_width;
        $this->video_height = $video_height;
        $this->video_duration = $video_duration;
        $this->description = $description;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->show_caption_above_media = $show_caption_above_media;
    }

    public static function make(
        string $id,
        string $video_url,
        string $mime_type,
        string $thumbnail_url,
        string $title,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?int $video_width = null,
        ?int $video_height = null,
        ?int $video_duration = null,
        ?string $description = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ): self {
        return new self(
            id: $id,
            video_url: $video_url,
            mime_type: $mime_type,
            thumbnail_url: $thumbnail_url,
            title: $title,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            video_width: $video_width,
            video_height: $video_height,
            video_duration: $video_duration,
            description: $description,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
            show_caption_above_media: $show_caption_above_media,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'id' => $this->id,
            'video_url' => $this->video_url,
            'mime_type' => $this->mime_type,
            'thumbnail_url' => $this->thumbnail_url,
            'title' => $this->title,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode,
            'caption_entities' => $this->caption_entities,
            'video_width' => $this->video_width,
            'video_height' => $this->video_height,
            'video_duration' => $this->video_duration,
            'description' => $this->description,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'show_caption_above_media' => $this->show_caption_above_media,
        ]);
    }
}
