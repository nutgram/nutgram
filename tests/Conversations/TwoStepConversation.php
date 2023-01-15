<?php


namespace SergiX44\Nutgram\Tests\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class TwoStepConversation extends Conversation
{
    protected ?string $step = 'firstStep';

    public function firstStep(Nutgram $bot)
    {
        $bot->setData('test', 1);
        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot)
    {
        $bot->setData('test', 2);
        $this->end();
    }
}
