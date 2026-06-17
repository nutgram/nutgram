<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A divider, corresponding to the HTML tag <code><hr/></code>.
 * @see https://core.telegram.org/bots/api#richblockdivider
 */
class RichBlockDivider extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “divider”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::DIVIDER;
}
