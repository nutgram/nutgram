<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to an mp3 audio file stored on the Telegram servers.
 * By default, this audio file will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the audio.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedaudio
 */
class InlineQueryResultCachedAudio
{
    /**
     * Type of the result, must be audio
     * @var string
     */
    public string $type;
    
    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;
    
    /**
     * A valid file identifier for the audio file
     * @var string
     */
    public string $audio_file_id;
    
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
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;
    
    /**
     * Optional. Content of the message to be sent instead of the audio
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
