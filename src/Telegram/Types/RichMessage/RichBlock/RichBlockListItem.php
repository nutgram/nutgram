<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockListItemType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * An item of a list.
 * @see https://core.telegram.org/bots/api#richblocklistitem
 */
class RichBlockListItem extends BaseType
{
    /**
     * Label of the item
     */
    public string $label;

    /**
     * The content of the item
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. True, if the item has a checkbox
     */
    public ?bool $has_checkbox = null;

    /**
     * Optional. True, if the item has a checked checkbox
     */
    public ?bool $is_checked = null;

    /**
     * Optional. For ordered lists, the numeric value of the item label
     */
    public ?int $value = null;

    /**
     * Optional. For ordered lists, the type of the item label; must be one of
     * - “a” for lowercase letters,
     * - “A” for uppercase letters,
     * - “i” for lowercase Roman numerals,
     * - “I” for uppercase Roman numerals, or
     * - “1” for decimal numbers
     */
    #[EnumOrScalar]
    public RichBlockListItemType|string|null $type = null;
}
