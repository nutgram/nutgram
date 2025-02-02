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
 * Represents a link to a voice message stored on the Telegram servers.
 * By default, this voice message will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the voice message.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedvoice
 */
class InlineQueryResultCachedVoice extends InlineQueryResult
{
    /** Type of the result, must be voice */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::VOICE;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid file identifier for the voice message */
    public string $voice_file_id;

    /** Voice message title */
    public string $title;

    /**
     * Optional.
     * Caption, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the voice message caption.
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
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the voice message
     */
    public ?InputMessageContent $input_message_content = null;

    public function __construct(
        string $id,
        string $voice_file_id,
        string $title,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->voice_file_id = $voice_file_id;
        $this->title = $title;
        $this->caption = $caption;
        $this->parse_mode = $parse_mode;
        $this->caption_entities = $caption_entities;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
    }

    public static function make(
        string $id,
        string $voice_file_id,
        string $title,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
    ): self {
        return new self(
            id: $id,
            voice_file_id: $voice_file_id,
            title: $title,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'id' => $this->id,
            'voice_file_id' => $this->voice_file_id,
            'title' => $this->title,
            'caption' => $this->caption,
            'parse_mode' => $this->parse_mode,
            'caption_entities' => $this->caption_entities,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
        ]);
    }
}
