<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class NonSerializableConversation extends Conversation
{
    protected ?\Closure $c = null;

    protected function getSerializableAttributes(): array
    {
        return [
            'c' => null,
        ];
    }

    public function start(Nutgram $bot)
    {
        $this->c = function () {
        };
        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot)
    {
        $bot->set('test', 'ok');
        $this->end();
    }
}
