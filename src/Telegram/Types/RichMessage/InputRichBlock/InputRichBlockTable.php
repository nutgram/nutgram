<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockTableCell;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;

/**
 * A table, corresponding to the HTML tag <code><table></code>.
 * @see https://core.telegram.org/bots/api#inputrichblocktable
 */
#[SkipConstructor]
class InputRichBlockTable extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “table”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::TABLE;

    /**
     * Cells of the table
     * @var RichBlockTableCell[][]
     */
    #[ArrayType(RichBlockTableCell::class, 2)]
    public array $cells;

    /**
     * Optional. Pass True if the table has borders
     */
    public ?bool $is_bordered = null;

    /**
     * Optional. Pass True if the table is striped
     */
    public ?bool $is_striped = null;

    /**
     * Optional. Caption of the table
     */
    public ?RichText $caption = null;

    public function __construct(
        array $cells,
        ?bool $is_bordered = null,
        ?bool $is_striped = null,
        ?RichText $caption = null,
    ) {
        parent::__construct();
        $this->cells = $cells;
        $this->is_bordered = $is_bordered;
        $this->is_striped = $is_striped;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
