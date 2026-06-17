<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;

/**
 * A block with an animation, corresponding to the HTML tag <code><video></code>.
 * @see https://core.telegram.org/bots/api#richblockanimation
 */
class RichBlockAnimation extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “animation”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::ANIMATION;

    /**
     * The animation
     */
    public Animation $animation;

    /**
     * Optional. True, if the media preview is covered by a spoiler animation
     */
    public ?bool $has_spoiler;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
