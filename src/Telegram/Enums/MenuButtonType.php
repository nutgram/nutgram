<?php

namespace SergiX44\Nutgram\Telegram\Enums;

use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonCommands;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonDefault;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonWebApp;

class MenuButtonType extends BaseEnum
{
    public const COMMANDS = MenuButtonCommands::class;
    public const DEFAULT = MenuButtonDefault::class;
    public const WEB_APP = MenuButtonWebApp::class;
}
