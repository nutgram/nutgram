<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAudio;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a music file, corresponding to the HTML tag <code><audio></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockaudio
 */
#[SkipConstructor]
class InputRichBlockAudio extends BaseType implements InputRichBlock, JsonSerializable
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

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
