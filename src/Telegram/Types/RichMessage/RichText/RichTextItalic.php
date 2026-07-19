<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * An italicized text.
 * @see https://core.telegram.org/bots/api#richtextitalic
 */
class RichTextItalic extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “italic”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::ITALIC;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, 16)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;
}
