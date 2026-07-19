<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A slideshow, corresponding to the custom HTML tag <code><tg-slideshow></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockslideshow
 */
#[SkipConstructor]
class InputRichBlockSlideshow extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “slideshow”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::SLIDESHOW;

    /**
     * Elements of the slideshow
     * @var InputRichBlock[]
     */
    #[ArrayType(InputRichBlock::class)]
    public array $blocks;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(array $blocks, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->blocks = $blocks;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
