<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberAdministrator;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberBanned;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberLeft;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberMember;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberOwner;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberRestricted;

class ChatMemberType extends BaseEnum
{
    public const OWNER = ChatMemberOwner::class;
    public const ADMINISTRATOR = ChatMemberAdministrator::class;
    public const MEMBER = ChatMemberMember::class;
    public const RESTRICTED = ChatMemberRestricted::class;
    public const LEFT = ChatMemberLeft::class;
    public const BANNED = ChatMemberBanned::class;
}
