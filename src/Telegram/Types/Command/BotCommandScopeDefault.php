<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;

/**
 * Represents the default {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands.
 * Default commands are used if no commands with a {@see https://core.telegram.org/bots/api#determining-list-of-commands narrower scope} are specified for the user.
 * @see https://core.telegram.org/bots/api#botcommandscopedefault
 */
class BotCommandScopeDefault extends BotCommandScope
{
    /** Scope type, must be default */
    #[EnumOrScalar]
    public BotCommandScopeType|string $type = BotCommandScopeType::DEFAULT;

    public function make(): self
    {
        return new self();
    }
}
