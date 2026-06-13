<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A strikethrough text.
 * @see https://core.telegram.org/bots/api#richtextstrikethrough
 */
class RichTextStrikethrough extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “strikethrough”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::STRIKETHROUGH;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    public string|array|RichText $text;
}
