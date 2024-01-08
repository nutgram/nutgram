<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents the scope to which bot commands are applied.
 * Currently, the following 7 scopes are supported:
 * - {@see BotCommandScopeDefault BotCommandScopeDefault}
 * - {@see BotCommandScopeAllPrivateChats BotCommandScopeAllPrivateChats}
 * - {@see BotCommandScopeAllGroupChats BotCommandScopeAllGroupChats}
 * - {@see BotCommandScopeAllChatAdministrators BotCommandScopeAllChatAdministrators}
 * - {@see BotCommandScopeChat BotCommandScopeChat}
 * - {@see BotCommandScopeChatAdministrators BotCommandScopeChatAdministrators}
 * - {@see BotCommandScopeChatMember BotCommandScopeChatMember}
 * @see https://core.telegram.org/bots/api#botcommandscope
 */
#[BotCommandScopeResolver]
abstract class BotCommandScope extends BaseType implements JsonSerializable
{
    #[EnumOrScalar]
    public BotCommandScopeType|string $type;

    public function getType(): BotCommandScopeType
    {
        return $this->type;
    }

    public function __serialize(): array
    {
        return ['type' => $this->getType()->value];
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
