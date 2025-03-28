<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ValidReopenMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText('Choose a color:')
            ->addButtonRow(new InlineKeyboardButton('Red', callback_data: 'red@handleColor'))
            ->addButtonRow(new InlineKeyboardButton('Green', callback_data: 'green@handleColor'))
            ->addButtonRow(new InlineKeyboardButton('Yellow', callback_data: 'yellow@handleColor'))
            ->showMenu();
    }

    public function handleColor(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: $color!")
            ->clearButtons()
            ->showMenu(reopen: true);
    }
}
