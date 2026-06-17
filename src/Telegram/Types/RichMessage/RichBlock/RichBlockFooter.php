<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * A footer, corresponding to the HTML tag <code><footer></code>.
 * @see https://core.telegram.org/bots/api#richblockfooter
 */
class RichBlockFooter extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “footer”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::FOOTER;

    /**
     * Text of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;
}
