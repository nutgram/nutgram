<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ChatMemberStatus: string
{
    case CREATOR = 'creator';
    case ADMINISTRATOR = 'administrator';
    case MEMBER = 'member';
    case RESTRICTED = 'restricted';
    case LEFT = 'left';
    case KICKED = 'kicked';
}
