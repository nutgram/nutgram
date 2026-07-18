<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAnimation;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with an animation, corresponding to the HTML tag <code><video></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockanimation
 */
#[SkipConstructor]
class InputRichBlockAnimation extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “animation”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::ANIMATION;

    /**
     * The animation. Caption is ignored.
     */
    public InputMediaAnimation $animation;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaAnimation $animation, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->animation = $animation;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
