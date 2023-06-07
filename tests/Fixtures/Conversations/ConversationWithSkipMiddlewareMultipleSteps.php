<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ConversationWithSkipMiddlewareMultipleSteps extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->set('test', $bot->get('test', 0) + 1);
        $this->setSkipMiddlewares(true)->next('second');
    }

    public function second(Nutgram $bot)
    {
        $bot->set('test', $bot->get('test', 0) + 1);
        $this->end();
    }
}
