<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all group and supergroup chats.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopeallgroupchats
 */
class BotCommandScopeAllGroupChats
{
    /**
     * Scope type, must be all_group_chats
     * @var string $type
     */
    public $type;
}
