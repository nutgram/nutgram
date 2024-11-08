<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ValidPhotoMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $file = fopen('php://temp', 'r+');
        $this->menuText('Choose a color:')
            ->setPhoto($file)
            ->addButtonRow(InlineKeyboardButton::make('Red', callback_data: 'red@handleColor'))
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
