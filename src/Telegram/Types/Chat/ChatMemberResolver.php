<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use Attribute;
use InvalidArgumentException;
use SergiX44\Hydrator\Annotation\ConcreteResolver;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatMemberResolver extends ConcreteResolver
{
    public function getConcreteClass(array $data): string
    {
        return match ($data['status']) {
            'creator' => ChatMemberOwner::class,
            'administrator' => ChatMemberAdministrator::class,
            'member' => ChatMemberMember::class,
            'restricted' => ChatMemberRestricted::class,
            'left' => ChatMemberLeft::class,
            'kicked' => ChatMemberBanned::class,
            default => throw new InvalidArgumentException('Unknown ChatMember status: '.$data['status']),
        };
    }
}
