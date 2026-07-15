<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockListItemType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * An item of a list to be sent.
 * @see https://core.telegram.org/bots/api#inputrichblocklistitem
 */
#[SkipConstructor]
class InputRichBlockListItem extends BaseType implements JsonSerializable
{
    /**
     * The content of the item
     * @var InputRichBlock[]
     */
    #[ArrayType(InputRichBlock::class)]
    public array $blocks;

    /**
     * Optional. Pass True if the item has a checkbox
     */
    public ?bool $has_checkbox = null;

    /**
     * Optional. Pass True if the item has a checked checkbox
     */
    public ?bool $is_checked = null;

    /**
     * Optional. For ordered lists, the numeric value of the item label
     */
    public ?int $value = null;

    /**
     * Optional.
     * For ordered lists, the type of the item label; must be one of
     * - “a” for lowercase letters
     * - “A” for uppercase letters
     * - “i” for lowercase Roman numerals
     * - “I” for uppercase Roman numerals
     * - “1” for decimal numbers
     */
    #[EnumOrScalar]
    public RichBlockListItemType|string|null $type = null;

    public function __construct(
        array $blocks,
        ?bool $has_checkbox = null,
        ?bool $is_checked = null,
        ?int $value = null,
        RichBlockListItemType|string|null $type = null,
    ) {
        parent::__construct();
        $this->blocks = $blocks;
        $this->has_checkbox = $has_checkbox;
        $this->is_checked = $is_checked;
        $this->value = $value;
        $this->type = $type;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
