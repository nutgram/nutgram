<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

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
 *
 * @see https://core.telegram.org/bots/api#botcommandscope
 */
#[BotCommandScopeResolver]
abstract class BotCommandScope extends BaseType
{
    public string $type;

    public function getType(): string
    {
        return $this->type;
    }

    public function __serialize(): array
    {
        return ['type' => $this->getType()];
    }
}
