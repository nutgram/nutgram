<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

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
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string $id
     */
    public $id;

    /**
     * A valid URL for the voice recording
     * @var string $voice_url
     */
    public $voice_url;

    /**
     * Recording title
     * @var string $title
     */
    public $title;

    /**
     * Optional. Caption, 0-1024 characters
     * @var string $caption
     */
    public $caption;

    /**
     * Optional. Send {@see https://core.telegram.org/bots/api#markdown-style Markdown} or
     * {@see https://core.telegram.org/bots/api#html-style HTML},
     * if you want Telegram apps to show
     * {@see https://core.telegram.org/bots/api#formatting-options bold, italic, fixed-width text or inline URLs}
     * in your bot's message.
     * @var string $parse_mode
     */
    public $parse_mode;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    public $caption_entities;

    /**
     * Optional. Recording duration in seconds
     * @var int $voice_duration
     */
    public $voice_duration;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup $reply_markup
     */
    public $reply_markup;

    /**
     *Optional. Content of the message to be sent instead of the voice recording
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent $input_message_content
     */
    public $input_message_content;
}
