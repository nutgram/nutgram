<?php

namespace SergiX44\Nutgram\Tests\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ValidButtonNoCallbackMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText('Choose a color:')
            ->addButtonRow(InlineKeyboardButton::make('Red'))
            ->showMenu();
    }

    public function handleColor(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: $color!")
            ->clearButtons()
            ->showMenu();
    }
}
