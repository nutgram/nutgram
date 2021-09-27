<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

use SergiX44\Nutgram\Telegram\Types\ChatMemberAdministrator;
use SergiX44\Nutgram\Telegram\Types\ChatMemberBanned;
use SergiX44\Nutgram\Telegram\Types\ChatMemberLeft;
use SergiX44\Nutgram\Telegram\Types\ChatMemberMember;
use SergiX44\Nutgram\Telegram\Types\ChatMemberOwner;
use SergiX44\Nutgram\Telegram\Types\ChatMemberRestricted;

class ChatMemberType
{
    public const OWNER = ChatMemberOwner::class;
    public const ADMINISTRATOR = ChatMemberAdministrator::class;
    public const MEMBER = ChatMemberMember::class;
    public const RESTRICTED = ChatMemberRestricted::class;
    public const LEFT = ChatMemberLeft::class;
    public const BANNED = ChatMemberBanned::class;
}
