<?php

class TestConversation extends \SergiX44\Nutgram\Conversation\Conversation
{
    protected string $step = 'firstStep';

    protected bool $skipHandlers = true;

    public function firstStep(\SergiX44\Nutgram\Nutgram $bot)
    {
        $this->next('secondStep');
    }

    public function secondStep(\SergiX44\Nutgram\Nutgram $bot)
    {
        die();
    }
}

it('start a new conversation', function () {
    $file = file_get_contents(__DIR__.'/Updates/message.json');

    $bot = getInstance(json_decode($file));
    $bot->onMessage(TestConversation::class);
    $bot->run();
    $bot->run();
});
