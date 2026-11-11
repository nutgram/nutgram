<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

class TextQuote extends BaseType
{
    /**
     * Text of the quoted part of a message that is replied to by the given message
     * @var string
     */
    public string $text;

    /**
     * Optional. Special entities that appear in the quote.
     * Currently, only bold, italic, underline, strikethrough, spoiler, custom_emoji, and date_time entities are kept in quotes.
     * @var MessageEntity[]|null
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;


    /**
     * Optional. Rich text of the quote if it was chosen from a {@see https://core.telegram.org/bots/api#richmessage rich message}.
     * May contain only plain text,
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
     * and arrays of them.
     * @var string|RichText|array<mixed>|null
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $rich_texts = null;

    /**
     * Approximate quote position in the original message in UTF-16 code units as specified by the sender
     * @var int
     */
    public int $position;

    /**
     * Optional. True, if the quote was chosen manually by the message sender. Otherwise, the quote was added automatically by the server.
     * @var bool|null
     */
    public ?bool $is_manual = null;
}
