<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockButtonsAlign;
use SergiX44\Nutgram\Telegram\Properties\InputRichBlockType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichMessageButton;

/**
 * A block containing a list of buttons that are shown in one row,
 * corresponding to the custom HTML tag <tg-button-row>.
 * @see https://core.telegram.org/bots/api#inputrichblockbuttons
 */
#[SkipConstructor]
class InputRichBlockButtons extends BaseType implements InputRichBlock, JsonSerializable
{
    /**
     * Type of the block, always “buttons”
     */
    public InputRichBlockType|string $type = InputRichBlockType::BUTTONS;

    /**
     * List of 1-8 buttons to send
     * @var RichMessageButton[]
     */
    public array $buttons;

    /**
     * Optional. Horizontal alignment of the buttons.
     * Currently, must be one of “left”, “center”, or “right”.
     */
    public InputRichBlockButtonsAlign|string|null $align = null;

    public function __construct(InputRichBlockButtonsAlign|string|null $align = null)
    {
        $this->align = $align;
        $this->buttons = [];
    }

    public function addButton(RichMessageButton $button): static
    {
        $this->buttons[] = $button;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
