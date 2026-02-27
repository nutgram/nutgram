<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

class MultiTypeConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->set('test', 'start');

        $this
            ->next('getText', MessageType::TEXT)
            ->next('getCallbackQuery', UpdateType::CALLBACK_QUERY) //OR: fn (Nutgram $bot) => $bot->isCallbackQuery()
            ->next('custom', fn (Nutgram $bot) => $bot->update()->channel_post?->text !== null)
            ->next('invalid'); // default behavior, it will check any update
    }

    public function invalid(Nutgram $bot)
    {
        $bot->sendMessage('Invalid message type.');

        $this->start($bot);
    }

    public function getText(Nutgram $bot)
    {
        $bot->set('test', 'text');

        $this->end();
    }

    public function getCallbackQuery(Nutgram $bot)
    {
        $bot->set('test', 'callback_query');

        $this->end();
    }

    public function custom(Nutgram $bot)
    {
        $bot->set('test', 'custom');

        $this->end();
    }
}
