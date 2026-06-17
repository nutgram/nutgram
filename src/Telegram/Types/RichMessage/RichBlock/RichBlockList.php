<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A list of blocks, corresponding to the HTML tag <code><ul></code> or <code><ol></code> with multiple nested tags <code><li></code>.
 * @see https://core.telegram.org/bots/api#richblocklist
 */
class RichBlockList extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “list”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::LIST;

    /**
     * Items of the list
     * @var RichBlockListItem[]
     */
    #[ArrayType(RichBlockListItem::class)]
    public array $items;
}
