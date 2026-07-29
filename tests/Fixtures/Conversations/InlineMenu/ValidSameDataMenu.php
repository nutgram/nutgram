<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ValidSameDataMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText('Choose a color:')
            ->addButtonRow(new InlineKeyboardButton('Red', callback_data: 'red@handleOneRed'))
            ->addButtonRow(new InlineKeyboardButton('Green', callback_data: 'red@handleTwoRed'))
            ->addButtonRow(new InlineKeyboardButton('Yellow', callback_data: 'red@handleThreeRed'))
            ->showMenu();
    }

    public function handleOneRed(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: 1$color!")
            ->clearButtons()
            ->showMenu();

        $this->setCallbackQueryOptions([
            'show_alert' => true,
            'text' => 'Alert!',
        ]);
    }

    public function handleTwoRed(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: 2$color!")
            ->clearButtons()
            ->showMenu();

        $this->setCallbackQueryOptions([
            'show_alert' => true,
            'text' => 'Alert!',
        ]);
    }

    public function handleThreeRed(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: 3$color!")
            ->clearButtons()
            ->showMenu();

        $this->setCallbackQueryOptions([
            'show_alert' => true,
            'text' => 'Alert!',
        ]);
    }
}
