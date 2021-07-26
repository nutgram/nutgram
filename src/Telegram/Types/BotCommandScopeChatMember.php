<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering a specific member of a group or supergroup chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechatmember
 */
class BotCommandScopeChatMember
{
    /**
     * Scope type, must be chat_member
     * @var string $type
     */
    public $type;

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     * @var int|string $chat_id
     */
    public $chat_id;

    /**
     * Unique identifier of the target user
     * @var int $user_id
     */
    public $user_id;
}
