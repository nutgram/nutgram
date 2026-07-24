<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * An expandable block for details disclosure, corresponding to the HTML tag <code><details></code>.
 * @see https://core.telegram.org/bots/api#richblockdetails
 */
class RichBlockDetails extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “details”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::DETAILS;

    /**
     * Always shown summary of the block
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $summary;

    /**
     * Content of the block
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. True, if the content of the block is visible by default
     */
    public ?bool $is_open = null;
}
