<?php

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ConversationWithClosing extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->set('test', $bot->get('test', 0) + 1);
        $this->end();
    }

    public function closing(Nutgram $bot)
    {
        $bot->set('test', $bot->get('test', 0) + 1);
    }
}
