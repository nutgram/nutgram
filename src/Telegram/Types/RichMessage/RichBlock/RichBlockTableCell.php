<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockTableCellAlign;
use SergiX44\Nutgram\Telegram\Properties\RichBlockTableCellValign;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;

/**
 * Cell in a table.
 * @see https://core.telegram.org/bots/api#richblocktablecell
 */
class RichBlockTableCell extends BaseType
{
    /**
     * Optional. Text in the cell. If omitted, then the cell is invisible.
     * @var string|RichText[]|RichText
     */
    #[ArrayType(RichText::class)]
    #[RichTextUnionResolver]
    public string|array|RichText|null $text = null;

    /**
     * Optional. True, if the cell is a header cell
     */
    public ?bool $is_header = null;

    /**
     * Optional. The number of columns the cell spans if it is bigger than 1
     */
    public ?int $colspan = null;

    /**
     * Optional. The number of rows the cell spans if it is bigger than 1
     */
    public ?int $rowspan = null;

    /**
     * Horizontal cell content alignment. Currently, must be one of “left”, “center”, or “right”.
     */
    #[EnumOrScalar]
    public RichBlockTableCellAlign|string $align;

    /**
     * Vertical cell content alignment. Currently, must be one of “top”, “middle”, or “bottom”.
     */
    #[EnumOrScalar]
    public RichBlockTableCellValign|string $valign;
}
