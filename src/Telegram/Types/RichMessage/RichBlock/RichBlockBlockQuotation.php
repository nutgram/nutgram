<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * A block quotation, corresponding to the HTML tag <code><blockquote></code>.
 * @see https://core.telegram.org/bots/api#richblockblockquotation
 */
class RichBlockBlockQuotation extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “blockquote”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::BLOCKQUOTE;

    /**
     * Content of the block
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $credit = null;
}
