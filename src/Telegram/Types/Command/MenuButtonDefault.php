<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;

/**
 * Describes that no specific value for the menu button was set.
 * @see https://core.telegram.org/bots/api#menubuttondefault
 */
class MenuButtonDefault extends MenuButton
{
    /** Type of the button, must be default */
    public MenuButtonType $type = MenuButtonType::DEFAULT;

    public function make(): self
    {
        return new self();
    }
}
