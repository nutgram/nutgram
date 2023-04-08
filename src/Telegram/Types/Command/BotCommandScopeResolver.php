<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Attributes\BotCommandScopeType;

#[Attribute(Attribute::TARGET_CLASS)]
class BotCommandScopeResolver extends ConcreteResolver
{
    protected array $concretes = [
        BotCommandScopeType::DEFAULT => BotCommandScopeDefault::class,
        BotCommandScopeType::ALL_PRIVATE_CHATS => BotCommandScopeAllPrivateChats::class,
        BotCommandScopeType::ALL_GROUP_CHATS => BotCommandScopeAllGroupChats::class,
        BotCommandScopeType::ALL_CHAT_ADMINISTRATORS => BotCommandScopeAllChatAdministrators::class,
        BotCommandScopeType::CHAT => BotCommandScopeChat::class,
        BotCommandScopeType::CHAT_ADMINISTRATORS => BotCommandScopeChatAdministrators::class,
        BotCommandScopeType::CHAT_MEMBER => BotCommandScopeChatMember::class,
    ];

    public function concreteFor(array $data): ?string
    {
        return $this->concretes[$data['type']] ?? throw new InvalidArgumentException('Unknown BotCommandScope type: '.$data['type']);
    }
}
