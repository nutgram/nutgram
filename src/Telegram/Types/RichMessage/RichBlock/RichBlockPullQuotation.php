<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\RichTextUnionResolver;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A quotation with centered text, loosely corresponding to the HTML tag <code><aside></code>.
 * @see https://core.telegram.org/bots/api#richblockpullquotation
 */
class RichBlockPullQuotation extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “pullquote”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::PULLQUOTE;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;

    /**
     * Optional. Credit of the block
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText|null $credit = null;
}
