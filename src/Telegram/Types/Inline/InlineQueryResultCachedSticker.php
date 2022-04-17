<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputContactMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputLocationMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputTextMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputVenueMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a link to a sticker stored on the Telegram servers.
 * By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 */
class InlineQueryResultCachedSticker extends InlineQueryResult
{
    /**
     * Type of the result, must be sticker
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     */
    public string $id;

    /**
     * A valid file identifier of the sticker
     */
    public string $sticker_file_id;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional. Content of the message to be sent instead of the sticker
     */
    public InputTextMessageContent|InputLocationMessageContent|InputVenueMessageContent|InputContactMessageContent|null $input_message_content;
}
