<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum MenuButtonType: string
{
    case COMMANDS = 'commands';
    case WEB_APP = 'web_app';
    case DEFAULT = 'default';
}
