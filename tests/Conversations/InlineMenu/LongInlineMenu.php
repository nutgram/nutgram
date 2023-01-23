<?php

namespace SergiX44\Nutgram\Tests\Conversations\InlineMenu;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Limits;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class LongInlineMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText(str_repeat('a', Limits::TEXT_LENGTH + 1))
            ->addButtonRow(InlineKeyboardButton::make('Red', callback_data: 'red@handleColor'))
            ->addButtonRow(InlineKeyboardButton::make('Green', callback_data: 'green@handleColor'))
            ->addButtonRow(InlineKeyboardButton::make('Yellow', callback_data: 'yellow@handleColor'))
            ->showMenu();
    }

    public function handleColor(Nutgram $bot)
    {
        $color = $bot->callbackQuery()->data;
        $this->menuText("Choosen: $color!")
            ->clearButtons()
            ->showMenu();

        $this->setCallbackQueryOptions([
            'show_alert' => true,
            'text' => 'Alert!',
        ]);
    }
}
