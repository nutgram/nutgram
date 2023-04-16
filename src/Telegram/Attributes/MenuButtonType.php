<?php

namespace SergiX44\Nutgram\Telegram\Attributes;

enum MenuButtonType: string
{
    case COMMANDS = 'commands';
    case DEFAULT = 'default';
    case WEB_APP = 'web_app';
}
