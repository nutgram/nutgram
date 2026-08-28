<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichBlock;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichBlockButtonsAlign;
use SergiX44\Nutgram\Telegram\Properties\RichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichMessageButton;

/**
 * A block containing a list of buttons that are shown in one row,
 * corresponding to the custom HTML tag <tg-button-row>.
 * @see https://core.telegram.org/bots/api#richblockbuttons
 */
class RichBlockButtons extends BaseType implements RichBlock
{
    /**
     * Type of the block, always “buttons”
     */
    #[EnumOrScalar]
    public RichBlockType|string $type = RichBlockType::BUTTONS;

    /**
     * The buttons
     * @var RichMessageButton[]
     */
    #[ArrayType(RichMessageButton::class)]
    public array $buttons;

    /**
     * Optional. Horizontal alignment of the buttons.
     * Currently, must be one of “left”, “center”, or “right”.
     */
    #[EnumOrScalar]
    public RichBlockButtonsAlign|string|null $align = null;
}
