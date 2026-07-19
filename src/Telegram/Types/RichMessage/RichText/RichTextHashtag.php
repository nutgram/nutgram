<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\UnionResolvers\RichTextUnionResolver;

/**
 * A hashtag.
 * @see https://core.telegram.org/bots/api#richtexthashtag
 */
class RichTextHashtag extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “hashtag”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::HASHTAG;

    /**
     * The text
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * The hashtag
     */
    public string $hashtag;
}
