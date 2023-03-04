<?php

namespace SergiX44\Nutgram\Telegram\Enums;

use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberAdministrator;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberBanned;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberLeft;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberMember;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberOwner;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberRestricted;

enum ChatMemberType: string
{
    case OWNER = ChatMemberOwner::class;
    case ADMINISTRATOR = ChatMemberAdministrator::class;
    case MEMBER = ChatMemberMember::class;
    case RESTRICTED = ChatMemberRestricted::class;
    case LEFT = ChatMemberLeft::class;
    case BANNED = ChatMemberBanned::class;
}
