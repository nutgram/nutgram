<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

/**
 * Describes that no specific value for the menu button was set.
 * @see https://core.telegram.org/bots/api#menubuttondefault
 */
trait MenuButtonDefault
{
    /**
     * Type of the button, must be default
     */
    public string $type;
}
