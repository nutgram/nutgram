<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a link to a sticker stored on the Telegram servers.
 * By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 */
#[OverrideConstructor('bindToInstance')]
class InlineQueryResultCachedSticker extends InlineQueryResult
{
    /** Type of the result, must be sticker */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::STICKER;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** A valid file identifier of the sticker */
    public string $sticker_file_id;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Optional.
     * Content of the message to be sent instead of the sticker
     */
    public ?InputMessageContent $input_message_content = null;

    public function __construct(
        string $id,
        string $sticker_file_id,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->sticker_file_id = $sticker_file_id;
        $this->reply_markup = $reply_markup;
        $this->input_message_content = $input_message_content;
    }
}
