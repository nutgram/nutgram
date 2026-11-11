<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Describes reply parameters for the message that is being sent.
 * @see https://core.telegram.org/bots/api#replyparameters
 */
#[SkipConstructor]
class ReplyParameters extends BaseType implements JsonSerializable
{
    /**
     * Optional.
     * Identifier of the message that will be replied to in the current chat, or in the chat chat_id if it is specified.
     * Required if ephemeral_message_id isn't specified.
     */
    public ?int $message_id = null;

    /**
     * Optional.
     * If the message to be replied to is from a different chat,
     * unique identifier for the chat or username of the channel (in the format [at]channelusername)
     * @var int|string|null
     */
    public int|string|null $chat_id = null;

    /**
     * Optional.
     * Identifier of the incoming ephemeral message that will be replied to in the current chat.
     * A reply to an ephemeral message must itself be an ephemeral message.
     * An ephemeral message may only be replied to within 15 seconds of being sent.
     * Required if message_id isn't specified.
     */
    public ?int $ephemeral_message_id = null;

    /**
     * Optional. Pass True if the message should be sent even if the specified message to be replied to is not found;
     * can be used only for replies in the same chat and forum topic.
     * @var bool|null
     */
    public ?bool $allow_sending_without_reply = null;

    /**
     * Optional. Quoted part of the message to be replied to; 0-1024 characters after entities parsing.
     * The quote must be an exact substring of the message to be replied to,
     * including bold, italic, underline, strikethrough, spoiler, custom_emoji, and date_time entities.
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
     * Optional. A JSON-serialized list of quoted parts of the {@see https://core.telegram.org/bots/api#richmessage rich message} to be replied to.
     * Must contain one element for each quoted text of the message in the order of their appearance.
     * Each of the following is a separate quoted text: the text of a paragraph, a heading, a preformatted block, a footer, or a mathematical expression;
     * the text and the credit of a block quotation or a pull quotation; the summary of a details block; the caption and each cell of a table;
     * the text and the credit of a caption of a media block, a collage, a slideshow, or a map.
     * Texts of blocks nested in lists, block quotations, details, collages, and slideshows are separate quoted texts too.
     * The first and the last elements can contain only a part of the corresponding text; all other elements must contain the whole text.
     * Formatting of the quoted parts must be kept, and rich texts must be nested in the same way as in the message received from the server.
     * Mathematical expressions must be quoted entirely.
     * Buttons in {@see https://core.telegram.org/bots/api#richblockbuttons RichBlockButtons}, anchors and dividers can't be quoted.
     * Up to 32 quoted texts with total length up to 1024 characters can be specified.
     * Only plain text,
     * {@see https://core.telegram.org/bots/api#richtextbold RichTextBold},
     * {@see https://core.telegram.org/bots/api#richtextitalic RichTextItalic},
     * {@see https://core.telegram.org/bots/api#richtextunderline RichTextUnderline},
     * {@see https://core.telegram.org/bots/api#richtextstrikethrough RichTextStrikethrough},
     * {@see https://core.telegram.org/bots/api#richtextspoiler RichTextSpoiler},
     * {@see https://core.telegram.org/bots/api#richtextsubscript RichTextSubscript},
     * {@see https://core.telegram.org/bots/api#richtextsuperscript RichTextSuperscript},
     * {@see https://core.telegram.org/bots/api#richtextdatetime RichTextDateTime},
     * {@see https://core.telegram.org/bots/api#richtextcustomemoji RichTextCustomEmoji},
     * {@see https://core.telegram.org/bots/api#richtextmathematicalexpression RichTextMathematicalExpression},
     * and arrays of them are kept in the quote;
     * other rich text types are replaced with their text.
     * If non-empty, then quote, quote_parse_mode and quote_entities are ignored.
     * @var string|RichText|array<mixed>|null
     */
    public string|array|RichText|null $quote_rich_texts = null;

    /**
     * Optional. Position of the quote in the original message in UTF-16 code units
     * @var int|null
     */
    public ?int $quote_position = null;

    /**
     * Optional. Identifier of the specific checklist task to be replied to
     * @var int|null
     */
    public ?int $checklist_task_id = null;

    /**
     * Optional. Persistent identifier of the specific poll option to be replied to
     */
    public ?string $poll_option_id = null;

    /**
     * @param int|null $message_id
     * @param int|string|null $chat_id
     * @param bool|null $allow_sending_without_reply
     * @param string|null $quote
     * @param string|null $quote_parse_mode
     * @param MessageEntity[]|null $quote_entities
     * @param int|null $quote_position
     * @param int|null $checklist_task_id
     * @param string|null $poll_option_id
     * @param int|null $ephemeral_message_id
     * @param string|RichText|array<mixed>|null $quote_rich_texts
     */
    public function __construct(
        ?int $message_id = null,
        int|string|null $chat_id = null,
        ?bool $allow_sending_without_reply = null,
        ?string $quote = null,
        ?string $quote_parse_mode = null,
        ?array $quote_entities = null,
        ?int $quote_position = null,
        ?int $checklist_task_id = null,
        ?string $poll_option_id = null,
        ?int $ephemeral_message_id = null,
        string|array|RichText|null $quote_rich_texts = null,
    ) {
        parent::__construct();
        $this->message_id = $message_id;
        $this->chat_id = $chat_id;
        $this->allow_sending_without_reply = $allow_sending_without_reply;
        $this->quote = $quote;
        $this->quote_parse_mode = $quote_parse_mode;
        $this->quote_entities = $quote_entities;
        $this->quote_position = $quote_position;
        $this->checklist_task_id = $checklist_task_id;
        $this->poll_option_id = $poll_option_id;
        $this->ephemeral_message_id = $ephemeral_message_id;
        $this->quote_rich_texts = $quote_rich_texts;
    }

    /**
     * @param int|null $message_id
     * @param int|string|null $chat_id
     * @param bool|null $allow_sending_without_reply
     * @param string|null $quote
     * @param string|null $quote_parse_mode
     * @param MessageEntity[]|null $quote_entities
     * @param int|null $quote_position
     * @param int|null $checklist_task_id
     * @param string|null $poll_option_id
     * @param int|null $ephemeral_message_id
     * @param string|RichText|array<mixed>|null $quote_rich_texts
     * @return self
     */
    public static function make(
        ?int $message_id = null,
        int|string|null $chat_id = null,
        ?bool $allow_sending_without_reply = null,
        ?string $quote = null,
        ?string $quote_parse_mode = null,
        ?array $quote_entities = null,
        ?int $quote_position = null,
        ?int $checklist_task_id = null,
        ?string $poll_option_id = null,
        ?int $ephemeral_message_id = null,
        string|array|RichText|null $quote_rich_texts = null,
    ): self {
        return new self(
            message_id: $message_id,
            chat_id: $chat_id,
            allow_sending_without_reply: $allow_sending_without_reply,
            quote: $quote,
            quote_parse_mode: $quote_parse_mode,
            quote_entities: $quote_entities,
            quote_position: $quote_position,
            checklist_task_id: $checklist_task_id,
            poll_option_id: $poll_option_id,
            ephemeral_message_id: $ephemeral_message_id,
            quote_rich_texts: $quote_rich_texts,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'message_id' => $this->message_id,
            'chat_id' => $this->chat_id,
            'ephemeral_message_id' => $this->ephemeral_message_id,
            'allow_sending_without_reply' => $this->allow_sending_without_reply,
            'quote' => $this->quote,
            'quote_parse_mode' => $this->quote_parse_mode,
            'quote_entities' => $this->quote_entities,
            'quote_position' => $this->quote_position,
            'checklist_task_id' => $this->checklist_task_id,
            'poll_option_id' => $this->poll_option_id,
            'quote_rich_texts' => $this->quote_rich_texts,
        ]);
    }
}
