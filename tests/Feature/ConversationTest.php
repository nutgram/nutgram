<?php

use SergiX44\Nutgram\Conversation;
use SergiX44\Nutgram\Nutgram;

class TestConversation extends Conversation
{
    protected string $step = 'firstStep';

    protected bool $skipHandlers = true;

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

it('calls the conversation steps', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message.json');

    $bot = getInstance(json_decode($file));
    $bot->onMessage(TestConversation::class);
    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
});
