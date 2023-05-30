<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a link to an MP3 audio file.
 * By default, this audio file will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the audio.
 * @see https://core.telegram.org/bots/api#inlinequeryresultaudio
 */
class InlineQueryResultAudio extends InlineQueryResult
{
    /** Type of the result, must be audio */
    public InlineQueryResultType $type = InlineQueryResultType::AUDIO;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid URL for the audio file */
    public string $audio_url;

    /** Title */
    public string $title;

    /**
     * Optional.
     * Caption, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the audio caption.
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
     * Performer
     */
    public ?string $performer = null;

    /**
     * Optional.
     * Audio duration in seconds
     */
    public ?int $audio_duration = null;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the audio
     */
    public ?InputMessageContent $input_message_content = null;
}
