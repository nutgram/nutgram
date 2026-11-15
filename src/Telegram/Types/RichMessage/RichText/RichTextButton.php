<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichMessageButton;

/**
 * A button.
 * @see https://core.telegram.org/bots/api#richtextbutton
 */
class RichTextButton extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “button”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::BUTTON;

    /**
     * The button
     */
    public RichMessageButton $button;
}
