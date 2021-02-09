<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a voice recording in an .ogg container encoded with OPUS.
 * By default, this voice recording will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the
 * specified content instead of the the voice message.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultvoice
 */
class InlineQueryResultVoice
{
    /**
     * Type of the result, must be voice
     * @var string
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;

    /**
     * A valid URL for the voice recording
     * @var string
     */
    public string $voice_url;

    /**
     * Recording title
     * @var string
     */
    public string $title;

    /**
     * Optional. Caption, 0-1024 characters
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
     * Optional. Recording duration in seconds
     * @var int
     */
    public int $voice_duration;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;

    /**
     *Optional. Content of the message to be sent instead of the voice recording
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
