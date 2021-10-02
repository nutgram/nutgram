<?php


namespace SergiX44\Nutgram\Tests\Feature\Conversations;

<<<<
<<< HEAD
use SergiX44\Nutgram\Conversations\Conversation;
=======
use SergiX44\Nutgram\Conversation;
>>>>>>> 475af68 (Apply fixes from StyleCI)
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
