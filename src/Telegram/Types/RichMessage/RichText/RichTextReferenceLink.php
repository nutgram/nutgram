<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A link to a reference.
 * @see https://core.telegram.org/bots/api#richtextreferencelink
 */
class RichTextReferenceLink extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “reference_link”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::REFERENCE_LINK;

    /**
     * The link text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    public string|array|RichText $text;

    /**
     * The name of the reference
     */
    public string $reference_name;
}
