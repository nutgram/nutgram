<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ChatJoinRequestResult: string
{
    case APPROVE = 'approve';
    case DECLINE = 'decline';
    case QUEUE = 'queue';
}
