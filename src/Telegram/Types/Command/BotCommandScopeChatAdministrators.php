<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering all administrators of a specific group or supergroup chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechatadministrators
 */
class BotCommandScopeChatAdministrators
{
    /**
     * Scope type, must be chat_administrators
     */
    public string $type;

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     */
    public int|string $chat_id;
}
