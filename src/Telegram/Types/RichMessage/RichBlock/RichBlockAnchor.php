<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A block with an anchor, corresponding to the HTML tag <code><a></code> with the attribute name.
 * @see https://core.telegram.org/bots/api#richblockanchor
 */
class RichBlockAnchor extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “anchor”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::ANCHOR;

    /**
     * The name of the anchor
     */
    public string $name;
}
