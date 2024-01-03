<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes reply parameters for the message that is being sent.
 * @see https://core.telegram.org/bots/api#replyparameters
 */
class ReplyParameters extends BaseType implements JsonSerializable
{
    /**
     * Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified
     * @var int
     */
    public int $message_id;

    /**
     * Optional. If the message to be replied to is from a different chat,
     * unique identifier for the chat or username of the channel (in the format [at]channelusername)
     * @var int|string|null
     */
    public int|string|null $chat_id = null;

    /**
     * Optional. Pass True if the message should be sent even if the specified message to be replied to is not found;
     * can be used only for replies in the same chat and forum topic.
     * @var bool|null
     */
    public ?bool $allow_sending_without_reply = null;

    /**
     * Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing.
     * The quote must be an exact substring of the message to be replied to, including bold, italic, underline, strikethrough, spoiler, and custom_emoji entities.
     * The message will fail to send if the quote isn't found in the original message.
     * @var string|null
     */
    public ?string $quote = null;

    /**
     * Optional. Mode for parsing entities in the quote. See formatting options for more details.
     * @var string|null
     */
    public ?string $quote_parse_mode = null;

    /**
     * Optional. A JSON-serialized list of special entities that appear in the quote.
     * It can be specified instead of quote_parse_mode.
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $quote_entities = null;

    /**
     * Optional. Position of the quote in the original message in UTF-16 code units
     * @var int|null
     */
    public ?int $quote_position = null;

    /**
     * @param int $message_id
     * @param int|string|null $chat_id
     * @param bool|null $allow_sending_without_reply
     * @param string|null $quote
     * @param string|null $quote_parse_mode
     * @param MessageEntity[]|null $quote_entities
     * @param int|null $quote_position
     */
    public function __construct(
        int $message_id,
        int|string|null $chat_id = null,
        ?bool $allow_sending_without_reply = null,
        ?string $quote = null,
        ?string $quote_parse_mode = null,
        ?array $quote_entities = null,
        ?int $quote_position = null
    ) {
        parent::__construct();
        $this->message_id = $message_id;
        $this->chat_id = $chat_id;
        $this->allow_sending_without_reply = $allow_sending_without_reply;
        $this->quote = $quote;
        $this->quote_parse_mode = $quote_parse_mode;
        $this->quote_entities = $quote_entities;
        $this->quote_position = $quote_position;
    }

    /**
     * @param int $message_id
     * @param int|string|null $chat_id
     * @param bool|null $allow_sending_without_reply
     * @param string|null $quote
     * @param string|null $quote_parse_mode
     * @param MessageEntity[]|null $quote_entities
     * @param int|null $quote_position
     * @return self
     */
    public static function make(
        int $message_id,
        int|string|null $chat_id = null,
        ?bool $allow_sending_without_reply = null,
        ?string $quote = null,
        ?string $quote_parse_mode = null,
        ?array $quote_entities = null,
        ?int $quote_position = null
    ): self {
        return new self(
            message_id: $message_id,
            chat_id: $chat_id,
            allow_sending_without_reply: $allow_sending_without_reply,
            quote: $quote,
            quote_parse_mode: $quote_parse_mode,
            quote_entities: $quote_entities,
            quote_position: $quote_position
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'message_id' => $this->message_id,
            'chat_id' => $this->chat_id,
            'allow_sending_without_reply' => $this->allow_sending_without_reply,
            'quote' => $this->quote,
            'quote_parse_mode' => $this->quote_parse_mode,
            'quote_entities' => $this->quote_entities,
            'quote_position' => $this->quote_position,
        ]);
    }
}
