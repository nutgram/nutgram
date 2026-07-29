<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * A block with a photo, corresponding to the HTML tag <code><photo></code>.
 * @see https://core.telegram.org/bots/api#richblockphoto
 */
class RichBlockPhoto extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “photo”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::PHOTO;

    /**
     * Available sizes of the photo
     * @var PhotoSize[] $photo
     */
    #[ArrayType(PhotoSize::class)]
    public array $photo;

    /**
     * Optional. True, if the media preview is covered by a spoiler animation
     */
    public ?bool $has_spoiler;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
