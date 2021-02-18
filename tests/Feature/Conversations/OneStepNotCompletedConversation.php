<?php


namespace SergiX44\Nutgram\Tests\Feature\Conversations;


use SergiX44\Nutgram\Conversation;
use SergiX44\Nutgram\Nutgram;

class OneStepNotCompletedConversation extends Conversation
{
    protected ?string $step = 'firstStep';

    public function firstStep(Nutgram $bot)
    {
        $bot->setData('test', $bot->getData('test', 1) + 1);
    }
}