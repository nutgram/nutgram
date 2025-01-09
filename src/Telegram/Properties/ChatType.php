<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ChatType: string
{
    case SENDER = 'sender';
    case PRIVATE = 'private';
    case GROUP = 'group';
    case SUPERGROUP = 'supergroup';
    case CHANNEL = 'channel';
}
