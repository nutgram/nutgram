<?php

namespace SergiX44\Nutgram\Tests\Feature\Conversations;

use SergiX44\Nutgram\Conversation;
use SergiX44\Nutgram\Nutgram;

class ConversationWithClosing extends Conversation
{

    public function start(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 0) + 1);
        $this->end();
    }

    public function closing(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 0) + 1);
    }
}