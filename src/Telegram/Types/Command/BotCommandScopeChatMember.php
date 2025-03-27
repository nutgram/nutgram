<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Command;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;

/**
 * Represents the {@see https://core.telegram.org/bots/api#botcommandscope scope} of bot commands, covering a specific member of a group or supergroup chat.
 * @see https://core.telegram.org/bots/api#botcommandscopechatmember
 */
class BotCommandScopeChatMember extends BotCommandScope
{
    /** Scope type, must be chat_member */
    #[EnumOrScalar]
    public BotCommandScopeType|string $type = BotCommandScopeType::CHAT_MEMBER;

    /** Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername) */
    public int|string $chat_id;

    /** Unique identifier of the target user */
    public int $user_id;

    public static function make(int|string $chat_id, int $user_id): self
    {
        $instance = new self;
        $instance->chat_id = $chat_id;
        $instance->user_id = $user_id;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
        ];
    }
}
