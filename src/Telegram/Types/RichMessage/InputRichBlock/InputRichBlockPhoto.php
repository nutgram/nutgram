<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock\RichBlockCaption;

/**
 * A block with a photo, corresponding to the HTML tag <code><img></code>.
 * @see https://core.telegram.org/bots/api#inputrichblockphoto
 */
#[OverrideConstructor('bindToInstance')]
class InputRichBlockPhoto extends BaseType implements InputRichBlock
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
}
