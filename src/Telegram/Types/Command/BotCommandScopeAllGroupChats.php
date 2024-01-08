<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands, covering all group and supergroup chats.
 * @see https://core.telegram.org/bots/api#botcommandscopeallgroupchats
 */
class BotCommandScopeAllGroupChats extends BotCommandScope
{
    /** Scope type, must be all_group_chats */
    #[EnumOrScalar]
    public BotCommandScopeType|string $type = BotCommandScopeType::ALL_GROUP_CHATS;

    public function make(): self
    {
        return new self();
    }
}
