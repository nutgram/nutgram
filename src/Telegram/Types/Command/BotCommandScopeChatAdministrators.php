<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all administrators of a specific group or supergroup chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechatadministrators
 */
class BotCommandScopeChatAdministrators extends BotCommandScope
{
    /**
     * Scope type, must be chat_administrators
     */
    public string $type = 'chat_administrators';

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     */
    public int|string $chat_id;

    public function getType(): string
    {
        return BotCommandScopeType::CHAT_ADMINISTRATORS;
    }

    public function getHash(): string
    {
        return $this->type.':'.$this->chat_id;
    }

    public static function apply(int|string $chat_id): static
    {
        $obj = new static();
        $obj->chat_id = $chat_id;
        return $obj;
    }
}
