<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a video, corresponding to the HTML tag <code><video></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockvideo
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockVideo extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “video”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::VIDEO;

    /**
     * The video. Caption is ignored.
     */
    public InputMediaVideo $video;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaVideo $video, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->video = $video;
        $this->caption = $caption;
    }
}
