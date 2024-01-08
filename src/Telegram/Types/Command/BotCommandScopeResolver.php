<?php

namespace SergiX44\Nutgram\Telegram\Types\Command;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\BotCommandScopeType;

#[Attribute(Attribute::TARGET_CLASS)]
class BotCommandScopeResolver extends ConcreteResolver
{
    protected array $concretes = [
        BotCommandScopeType::DEFAULT->value => BotCommandScopeDefault::class,
        BotCommandScopeType::ALL_PRIVATE_CHATS->value => BotCommandScopeAllPrivateChats::class,
        BotCommandScopeType::ALL_GROUP_CHATS->value => BotCommandScopeAllGroupChats::class,
        BotCommandScopeType::ALL_CHAT_ADMINISTRATORS->value => BotCommandScopeAllChatAdministrators::class,
        BotCommandScopeType::CHAT->value => BotCommandScopeChat::class,
        BotCommandScopeType::CHAT_ADMINISTRATORS->value => BotCommandScopeChatAdministrators::class,
        BotCommandScopeType::CHAT_MEMBER->value => BotCommandScopeChatMember::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $type = $data['type'] ?? throw new InvalidArgumentException('Type must be defined');
        return $this->concretes[$type] ?? (new class extends BotCommandScope {
        })::class;
    }
}
