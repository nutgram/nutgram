<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\RichTextUnionResolver;

/**
 * A text with a link.
 * @see https://core.telegram.org/bots/api#richtexturl
 */
class RichTextUrl extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “url”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::URL;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * URL of the link
     */
    public string $url;
}
