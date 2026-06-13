<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Voice;

/**
 * A block with a voice note, corresponding to the HTML tag <code><audio></code>.
 * @see https://core.telegram.org/bots/api#richblockvoicenote
 */
class RichBlockVoiceNote extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “voice_note”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::VOICE_NOTE;

    /**
     * The voice note
     */
    public Voice $voice_note;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;
}
