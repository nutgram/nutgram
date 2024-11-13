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
 * Represents a link to a file.
 * By default, this file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the file.
 * Currently, only .PDF and .ZIP files can be sent using this method.
 * @see https://core.telegram.org/bots/api#inlinequeryresultdocument
 */
class InlineQueryResultDocument extends InlineQueryResult
{
    /** Type of the result, must be document */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::DOCUMENT;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** Title for the result */
    public string $title;

    /**
     * Optional.
     * Caption of the document to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the document caption.
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

    /** A valid URL for the file */
    public string $document_url;

    /** MIME type of the content of the file, either “application/pdf” or “application/zip” */
    public string $mime_type;

    /**
     * Optional.
     * Short description of the result
     */
    public ?string $description = null;

    /**
     * Optional.
     * Inline keyboard attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the file
     */
    public ?InputMessageContent $input_message_content = null;

    /**
     * Optional.
     * URL of the thumbnail (JPEG only) for the file
     */
    public ?string $thumbnail_url = null;

    /**
     * Optional.
     * Thumbnail width
     */
    public ?int $thumbnail_width = null;

    /**
     * Optional.
     * Thumbnail height
     */
    public ?int $thumbnail_height = null;

    public function __construct(
        string $id,
        string $title,
        string $document_url,
        string $mime_type,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?string $description = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->document_url = $document_url;
        $this->mime_type = $mime_type;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->description = $description;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->thumbnail_url = $thumbnail_url;
        $this->thumbnail_width = $thumbnail_width;
        $this->thumbnail_height = $thumbnail_height;
    }

    public static function make(
        string $id,
        string $title,
        string $document_url,
        string $mime_type,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?string $description = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
    ): self {
        return new self(
            id: $id,
            title: $title,
            document_url: $document_url,
            mime_type: $mime_type,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            description: $description,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
            thumbnail_url: $thumbnail_url,
            thumbnail_width: $thumbnail_width,
            thumbnail_height: $thumbnail_height,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'id' => $this->id,
            'title' => $this->title,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode,
            'caption_entities' => $this->caption_entities,
            'document_url' => $this->document_url,
            'mime_type' => $this->mime_type,
            'description' => $this->description,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'thumbnail_url' => $this->thumbnail_url,
            'thumbnail_width' => $this->thumbnail_width,
            'thumbnail_height' => $this->thumbnail_height,
        ]);
    }
}
