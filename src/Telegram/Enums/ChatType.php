<?php

namespace SergiX44\Nutgram\Telegram\Enums;

enum ChatType: string
{
    case SENDER = 'sender';
    case PRIVATE = 'private';
    case GROUP = 'group';
    case SUPERGROUP = 'supergroup';
    case CHANNEL = 'channel';
}
