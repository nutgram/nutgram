<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all group and supergroup chat administrators.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopeallchatadministrators
 */
class BotCommandScopeAllChatAdministrators extends BotCommandScope
{
    /**
     * Scope type, must be all_chat_administrators
     */
    public string $type = 'all_chat_administrators';

    public function getType(): string
    {
        return BotCommandScopeType::ALL_CHAT_ADMINISTRATORS;
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
