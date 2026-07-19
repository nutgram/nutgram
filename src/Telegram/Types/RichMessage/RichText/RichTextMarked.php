<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A marked text.
 * @see https://core.telegram.org/bots/api#richtextmarked
 */
class RichTextMarked extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “marked”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::MARKED;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;
}
