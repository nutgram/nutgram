<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;

/**
 * A block with a map, corresponding to the custom HTML tag <code><tg-map></code>.
 * @see https://core.telegram.org/bots/api#richblockmap
 */
class RichBlockMap extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “map”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::MAP;

    /**
     * Location of the center of the map
     */
    public Location $location;

    /**
     * Map zoom level; 13-20
     */
    public int $zoom;

    /**
     * Expected width of the map
     */
    public int $width;

    /**
     * Expected height of the map
     */
    public int $height;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
