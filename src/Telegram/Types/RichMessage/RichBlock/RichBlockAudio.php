<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;

/**
 * A block with a music file, corresponding to the HTML tag <code><audio></code>.
 * @see https://core.telegram.org/bots/api#richblockaudio
 */
class RichBlockAudio extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “audio”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::AUDIO;

    /**
     * The audio
     */
    public Audio $audio;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
