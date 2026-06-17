<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Video;

/**
 * A block with a video, corresponding to the HTML tag <code><video></code>.
 * @see https://core.telegram.org/bots/api#richblockvideo
 */
class RichBlockVideo extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “video”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::VIDEO;

    /**
     * The video
     */
    public Video $video;

    /**
     * Optional. True, if the media preview is covered by a spoiler animation
     */
    public ?bool $has_spoiler;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
