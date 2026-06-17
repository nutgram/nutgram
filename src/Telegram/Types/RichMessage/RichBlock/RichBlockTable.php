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
 * A table, corresponding to the HTML tag <code><table></code>.
 * @see https://core.telegram.org/bots/api#richblocktable
 */
class RichBlockTable extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “table”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::TABLE;

    /**
     * Cells of the table
     * @var RichBlockTableCell[][]
     */
    #[ArrayType(RichBlockTableCell::class, 2)]
    public array $cells;

    /**
     * Optional. True, if the table has borders
     */
    public ?bool $is_bordered = null;

    /**
     * Optional. True, if the table is striped
     */
    public ?bool $is_striped = null;

    /**
     * Optional. Caption of the table
     * @var string|RichText[]|RichText|null
     */
    #[ArrayType(RichText::class)]
    #[BaseUnion]
    public string|array|RichText|null $caption = null;
}
