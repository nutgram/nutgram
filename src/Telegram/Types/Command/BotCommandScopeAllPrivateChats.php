<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all private chats.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopeallprivatechats
 */
class BotCommandScopeAllPrivateChats extends BotCommandScope
{
    /**
     * Scope type, must be all_private_chats
     */
    public string $type = 'all_private_chats';

    public function getType(): string
    {
        return BotCommandScopeType::ALL_PRIVATE_CHATS;
    }

    public function getHash(): string
    {
        return $this->type;
    }

    public static function apply(): static
    {
        return new static();
    }
}
