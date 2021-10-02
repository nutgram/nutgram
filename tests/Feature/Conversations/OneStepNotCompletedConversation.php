<?php


namespace SergiX44\Nutgram\Tests\Feature\Conversations;

<<<<
<<< HEAD
use SergiX44\Nutgram\Conversations\Conversation;
=======
use SergiX44\Nutgram\Conversation;
>>>>>>> 475af68 (Apply fixes from StyleCI)
use SergiX44\Nutgram\Nutgram;

class OneStepNotCompletedConversation extends Conversation
{
    protected ?string $step = 'firstStep';

    public function firstStep(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 1) + 1);
    }
}
