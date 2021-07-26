<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering a specific chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechat
 */
class BotCommandScopeChat
{
    /**
     * Scope type, must be chat
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     * @var int|string $chat_id
     */
    public $chat_id;
}
