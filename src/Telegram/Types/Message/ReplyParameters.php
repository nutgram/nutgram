<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes reply parameters for the message that is being sent.
 * @see https://core.telegram.org/bots/api#replyparameters
 */
class ReplyParameters extends BaseType
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
}
