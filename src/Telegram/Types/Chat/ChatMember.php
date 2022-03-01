<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use RuntimeException;
use SergiX44\Nutgram\Telegram\Attributes\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Attributes\ChatMemberType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object contains information about one member of a chat. Currently, the following 6 types of chat members are
 * supported:
 * @see ChatMemberOwner
 * @see ChatMemberAdministrator
 * @see ChatMemberMember
 * @see ChatMemberRestricted
 * @see ChatMemberLeft
 * @see ChatMemberBanned
 *
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMember extends BaseType
{
    use ChatMemberOwner;
    use ChatMemberAdministrator;
    use ChatMemberMember;
    use ChatMemberRestricted;
    use ChatMemberLeft;
    use ChatMemberBanned;

    /**
     * Information about the user
     */
    public User $user;


    public function getType(): ?string
    {
        return match ($this->status) {
            ChatMemberStatus::CREATOR => ChatMemberType::OWNER,
            ChatMemberStatus::ADMINISTRATOR => ChatMemberType::ADMINISTRATOR,
            ChatMemberStatus::MEMBER => ChatMemberType::MEMBER,
            ChatMemberStatus::RESTRICTED => ChatMemberType::RESTRICTED,
            ChatMemberStatus::LEFT => ChatMemberType::LEFT,
            ChatMemberStatus::KICKED => ChatMemberType::BANNED,
            default => throw new RuntimeException('Invalid ChatMemberStatus type'),
        };
    }
}
