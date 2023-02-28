<?php


namespace SergiX44\Nutgram\Tests\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class NonSerializableConversation extends Conversation
{
    protected ?\Closure $c;

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
        $bot->setData('test', 'ok');
        $this->end();
    }
}
