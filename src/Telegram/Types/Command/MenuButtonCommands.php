<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\MenuButtonType;

/**
 * Represents a menu button, which opens the bot's list of commands.
 * @see https://core.telegram.org/bots/api#menubuttoncommands
 */
class MenuButtonCommands extends MenuButton
{
    /** Type of the button, must be commands */
    #[EnumOrScalar]
    public MenuButtonType|string $type = MenuButtonType::COMMANDS;

    public function make(): self
    {
        return new self();
    }
}
