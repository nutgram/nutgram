<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ConversationWithHooks extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->set('start_called', true);
        $this->end();
    }

    public function closing(Nutgram $bot)
    {
        $bot->set('closing_called', true);
    }

    public function closed(Nutgram $bot)
    {
        $bot->set('closed_called', true);
    }
}
