<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum MessageOriginType: string
{
    case USER = 'user';
    case HIDDEN_USER = 'hidden_user';
    case CHAT = 'chat';
    case CHANNEL = 'channel';
}
