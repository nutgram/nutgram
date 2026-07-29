<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a map, corresponding to the custom HTML tag <code><tg-map></code>.
 * The map's width and height must not exceed 10000 in total.
 * The width and height ratio must be at most 20.
 * @see https://core.telegram.org/bots/api#inputrichblockmap
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockMap extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “map”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::MAP;

    /**
     * Location of the center of the map
     */
    public Location $location;

    /**
     * Map zoom level; 0-24
     */
    public int $zoom;

    /**
     * Map width; 0-10000
     */
    public int $width;

    /**
     * Map height; 0-10000
     */
    public int $height;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(
        Location $location,
        int $zoom,
        int $width,
        int $height,
        ?RichBlockCaption $caption = null
    ) {
        parent::__construct();
        $this->location = $location;
        $this->zoom = $zoom;
        $this->width = $width;
        $this->height = $height;
        $this->caption = $caption;
    }
}
