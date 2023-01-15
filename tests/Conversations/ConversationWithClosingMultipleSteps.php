<?php

namespace SergiX44\Nutgram\Tests\Conversations;

use SergiX44\Nutgram\Nutgram;

class ConversationWithClosingMultipleSteps extends ConversationWithClosing
{
    public function start(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 0) + 1);
        $this->next('second');
    }

    public function second(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 0) + 1);
        $this->end();
    }

    public function closing(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 0) + 1);
    }
}
