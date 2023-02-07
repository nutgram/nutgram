<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatMemberResolver extends ConcreteResolver
{
    protected array $concretes = [
        'creator' => ChatMemberOwner::class,
        'administrator' => ChatMemberAdministrator::class,
        'member' => ChatMemberMember::class,
        'restricted' => ChatMemberRestricted::class,
        'left' => ChatMemberLeft::class,
        'kicked' => ChatMemberBanned::class,
    ];

    public function concreteFor(array $data): ?string
    {
        return $this->concretes[$data['status']] ?? throw new InvalidArgumentException('Unknown ChatMember status: '.$data['status']);
    }
}
