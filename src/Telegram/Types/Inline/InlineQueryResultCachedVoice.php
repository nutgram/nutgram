<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a link to a voice message stored on the Telegram servers.
 * By default, this voice message will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the voice message.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedvoice
 */
class InlineQueryResultCachedVoice extends InlineQueryResult
{
    /** Type of the result, must be voice */
    public InlineQueryResultType $type = InlineQueryResultType::VOICE;

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
     * Content of the message to be sent instead of the voice message
     */
    public ?InputMessageContent $input_message_content = null;
}
