<?php

namespace SergiX44\Nutgram\Telegram\Enums;

use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonCommands;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonDefault;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonWebApp;

enum MenuButtonType: string
{
    case COMMANDS = MenuButtonCommands::class;
    case DEFAULT = MenuButtonDefault::class;
    case WEB_APP = MenuButtonWebApp::class;
}
