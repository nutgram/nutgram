<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A collage, corresponding to the custom HTML tag <code><tg-collage></code>.
 * @see https://core.telegram.org/bots/api#richblockcollage
 */
class RichBlockCollage extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “collage”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::COLLAGE;

    /**
     * Elements of the collage
     * @var RichBlock[]
     */
    #[ArrayType(RichBlock::class)]
    public array $blocks;

    /**
     * Optional. Caption of the block
     */
    public RichBlockCaption|null $caption = null;
}
