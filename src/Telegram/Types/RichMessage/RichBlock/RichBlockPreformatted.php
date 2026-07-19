<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * A preformatted text block, corresponding to the nested HTML tags <code><pre></code> and <code><code></code>.
 * @see https://core.telegram.org/bots/api#richblockpreformatted
 */
class RichBlockPreformatted extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “pre”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::PRE;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, 16)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * Optional. The programming language of the text
     */
    public ?string $language = null;
}
