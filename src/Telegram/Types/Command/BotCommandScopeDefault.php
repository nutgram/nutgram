<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

/**
 * Represents the default {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands.
 * Default commands are used if no commands with a
 * {@see https://core.telegram.org/bots/api#determining-list-of-commands narrower scope} are specified for the user.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopedefault
 */
class BotCommandScopeDefault
{
    /**
     * Scope type, must be default
     * @var string $type
     */
    public $type;
}
