<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVoiceNote;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a voice note, corresponding to the HTML tag <code><audio></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockvoicenote
 */
#[SkipConstructor]
class InputRichBlockVoiceNote extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “voice_note”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::VOICE_NOTE;

    /**
     * The voice note. Caption is ignored.
     */
    public InputMediaVoiceNote $voice_note;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaVoiceNote $voice_note, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->voice_note = $voice_note;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
