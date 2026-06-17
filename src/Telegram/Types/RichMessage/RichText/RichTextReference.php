<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\RichTextUnionResolver;

/**
 * A reference.
 * @see https://core.telegram.org/bots/api#richtextreference
 */
class RichTextReference extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “reference”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::REFERENCE;

    /**
     * Text of the reference
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * The name of the reference
     */
    public string $name;
}
