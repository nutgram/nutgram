<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatMemberResolver extends ConcreteResolver
{
    protected array $concretes = [
        ChatMemberStatus::CREATOR->value => ChatMemberOwner::class,
        ChatMemberStatus::ADMINISTRATOR->value => ChatMemberAdministrator::class,
        ChatMemberStatus::MEMBER->value => ChatMemberMember::class,
        ChatMemberStatus::RESTRICTED->value => ChatMemberRestricted::class,
        ChatMemberStatus::LEFT->value => ChatMemberLeft::class,
        ChatMemberStatus::KICKED->value => ChatMemberBanned::class,
    ];

    public function concreteFor(array $data): ?string
    {
        $status = $data['status'] ?? throw new InvalidArgumentException('Status must be defined');
        return $this->concretes[$status] ?? (new class extends ChatMember {
        })::class;
    }
}
