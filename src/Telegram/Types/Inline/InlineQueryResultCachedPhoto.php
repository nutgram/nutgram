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
 * Represents a link to a photo stored on the Telegram servers.
 * By default, this photo will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the photo.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedphoto
 */
class InlineQueryResultCachedPhoto extends InlineQueryResult
{
    /** Type of the result, must be photo */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::PHOTO;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid file identifier of the photo */
    public string $photo_file_id;

    /**
     * Optional.
     * Title for the result
     */
    public ?string $title = null;

    /**
     * Optional.
     * Short description of the result
     */
    public ?string $description = null;

    /**
     * Optional.
     * Caption of the photo to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the photo caption.
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
     * Content of the message to be sent instead of the photo
     */
    public ?InputMessageContent $input_message_content = null;

    public function __construct(
        string $id,
        string $photo_file_id,
        ?string $title = null,
        ?string $description = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->photo_file_id = $photo_file_id;
        $this->title = $title;
        $this->description = $description;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
        $this->show_caption_above_media = $show_caption_above_media;
    }

    public static function make(
        string $id,
        string $photo_file_id,
        ?string $title = null,
        ?string $description = null,
        ?string $caption = null,
        ?ParseMode $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
        ?bool $show_caption_above_media = null,
    ): self {
        return new self(
            id: $id,
            photo_file_id: $photo_file_id,
            title: $title,
            description: $description,
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
            'photo_file_id' => $this->photo_file_id,
            'title' => $this->title,
            'description' => $this->description,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode?->value,
            'caption_entities' => $this->caption_entities,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
            'show_caption_above_media' => $this->show_caption_above_media,
        ]);
    }
}
