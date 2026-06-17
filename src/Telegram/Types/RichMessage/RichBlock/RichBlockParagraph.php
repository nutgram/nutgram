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
 * A text paragraph, corresponding to the HTML tag <code><p></code>.
 * @see https://core.telegram.org/bots/api#richblockparagraph
 */
class RichBlockParagraph extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “paragraph”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::PARAGRAPH;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText $text;
}
