<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAudio;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a music file, corresponding to the HTML tag <code><audio></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockaudio
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockAudio extends BaseType implements InputRichBlock
{
    /**
     * Type of the block, always “audio”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::AUDIO;

    /**
     * The audio. Caption is ignored.
     */
    public InputMediaAudio $audio;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaAudio $audio, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->audio = $audio;
        $this->caption = $caption;
    }
}
