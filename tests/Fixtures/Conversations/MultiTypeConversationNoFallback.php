<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class MultiTypeConversationNoFallback extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->set('test', 'start');

        $bot->sendMessage(
            text: 'Waiting for a callback query...',
            reply_markup: new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton(text: 'Click me', callback_data: 'button_clicked'))
        );

        $this->next('getCallbackQuery', fn (Nutgram $bot) => $bot->isCallbackQuery());
    }

    public function getCallbackQuery(Nutgram $bot)
    {
        $bot->set('test', 'callback_query');

        $this->end();
    }
}
