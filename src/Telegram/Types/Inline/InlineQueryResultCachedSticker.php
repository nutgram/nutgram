<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a link to a sticker stored on the Telegram servers.
 * By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 */
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

    public static function make(
        string $id,
        string $sticker_file_id,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?InputMessageContent $input_message_content = null,
    ): self {
        return new self(
            id: $id,
            sticker_file_id: $sticker_file_id,
            reply_markup: $reply_markup,
            input_message_content: $input_message_content
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'id' => $this->id,
            'sticker_file_id' => $this->sticker_file_id,
            'reply_markup' => $this->reply_markup,
            'input_message_content' => $this->input_message_content,
        ]);
    }
}
