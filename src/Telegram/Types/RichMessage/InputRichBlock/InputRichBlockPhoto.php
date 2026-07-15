<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a photo, corresponding to the HTML tag <code><img></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockphoto
 */
#[SkipConstructor]
class InputRichBlockPhoto extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “photo”
     */
    #[EnumOrScalar]
    public InputRichBlockType|string $type = InputRichBlockType::PHOTO;

    /**
     * The photo. Caption is ignored.
     */
    public InputMediaPhoto $photo;

    /**
     * Optional. Caption of the block
     */
    public ?RichBlockCaption $caption = null;

    public function __construct(InputMediaPhoto $photo, ?RichBlockCaption $caption = null)
    {
        parent::__construct();
        $this->photo = $photo;
        $this->caption = $caption;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
