<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;

/**
 * Represents a menu button, which opens the bot's list of commands.
 * @see https://core.telegram.org/bots/api#menubuttoncommands
 */
class MenuButtonCommands extends MenuButton
{
    /** Type of the button, must be commands */
    public MenuButtonType $type = MenuButtonType::COMMANDS;

    public function make(): self
    {
        return new self();
    }
}
