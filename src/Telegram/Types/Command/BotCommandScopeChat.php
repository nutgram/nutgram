<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering a specific chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechat
 */
class BotCommandScopeChat extends BotCommandScope
{
    /**
     * Scope type, must be chat
     */
    public string $type = BotCommandScopeType::CHAT;

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     */
    public int|string $chat_id;

    public function __construct(int|string $chat_id)
    {
        parent::__construct();
        $this->chat_id = $chat_id;
    }
}
