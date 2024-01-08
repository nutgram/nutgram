<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands, covering all private chats.
 * @see https://core.telegram.org/bots/api#botcommandscopeallprivatechats
 */
class BotCommandScopeAllPrivateChats extends BotCommandScope
{
    /** Scope type, must be all_private_chats */
    #[EnumOrScalar]
    public BotCommandScopeType|string $type = BotCommandScopeType::ALL_PRIVATE_CHATS;

    public function make(): self
    {
        return new self();
    }
}
