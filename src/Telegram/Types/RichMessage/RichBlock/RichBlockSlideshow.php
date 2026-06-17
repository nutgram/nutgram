<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A slideshow, corresponding to the custom HTML tag <code><tg-slideshow></code>.
 * @see https://core.telegram.org/bots/api#richblockcollage
 */
class RichBlockSlideshow extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “slideshow”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::SLIDESHOW;

    /**
     * Elements of the slideshow
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. Caption of the block
     */
    public RichBlockCaption|null $caption = null;
}
