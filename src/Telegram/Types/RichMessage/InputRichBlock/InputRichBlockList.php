<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * A list of blocks, corresponding to the HTML tag <code><ul></code> or <code><ol></code> with multiple nested tags <code><li></code>.
 * @see https://core.telegram.org/bots/api#inputrichblocklist
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockList extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “list”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::LIST;

    /**
     * Items of the list
     * @var InputRichBlockListItem[]
     */
    #[ArrayType(InputRichBlockListItem::class)]
    public array $items;

    public function __construct(array $items)
    {
        parent::__construct();
        $this->items = $items;
    }
}
