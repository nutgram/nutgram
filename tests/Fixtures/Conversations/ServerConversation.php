<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ServerConversation extends Conversation
{
    public function start(Nutgram $bot): void
    {
        $bot->sendMessage('First step');
        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot): void
    {
        $bot->sendMessage('Second step');
        $this->end();
    }
}
