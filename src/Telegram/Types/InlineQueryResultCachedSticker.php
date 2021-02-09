<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a link to a sticker stored on the Telegram servers.
 * By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 */
class InlineQueryResultCachedSticker
{
    /**
     * Type of the result, must be sticker
     * @var string
     */
    public string $type;
    
    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;
    
    /**
     * A valid file identifier of the sticker
     * @var string
     */
    public string $sticker_file_id;
    
    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;
    
    /**
     * Optional. Content of the message to be sent instead of the sticker
     * @var InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent
     */
    public $input_message_content;
}
