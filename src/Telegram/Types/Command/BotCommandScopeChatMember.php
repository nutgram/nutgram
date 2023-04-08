<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope}
 * of bot commands, covering a specific member of a group or supergroup chat.
 *
 * @see https://core.telegram.org/bots/api#botcommandscopechatmember
 */
class BotCommandScopeChatMember extends BotCommandScope
{
    /**
     * Scope type, must be chat_member
     */
    public string $type = 'chat_member';

    /**
     * Unique identifier for the target chat or username
     * of the target supergroup (in the format  &#64;supergroupusername)
     */
    public int|string $chat_id;

    /**
     * Unique identifier of the target user
     */
    public int $user_id;

    public function getType(): string
    {
        return BotCommandScopeType::CHAT_MEMBER;
    }

    public function getHash(): string
    {
        return $this->type.':'.$this->chat_id.':'.$this->user_id;
    }

    public static function apply(int|string $chat_id, int $user_id): static
    {
        $obj = new static();
        $obj->chat_id = $chat_id;
        $obj->user_id = $user_id;
        return $obj;
    }
}
