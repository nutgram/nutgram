<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

class TextQuote extends BaseType
{
    /**
     * Text of the quoted part of a message that is replied to by the given message
     * @var string
     */
    public string $text;

    /**
     * Optional. Special entities that appear in the quote. Currently, only bold, italic, underline, strikethrough, spoiler, and custom_emoji entities are kept in quotes.
     * @var MessageEntity[]
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;

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
