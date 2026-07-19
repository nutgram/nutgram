<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A slideshow, corresponding to the custom HTML tag <code><tg-slideshow></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockslideshow
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockSlideshow extends BaseType implements InputRichBlock
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
}
