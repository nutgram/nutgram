<?php

use SergiX44\Nutgram\Tests\Feature\Conversations\OneStepNotCompletedConversation;
use SergiX44\Nutgram\Tests\Feature\Conversations\TwoStepConversation;

it('calls the conversation steps', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message.json');

    $bot = getInstance(json_decode($file));
    $bot->onMessage(TwoStepConversation::class);
    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
});

it('calls the same handler if not end or next step called', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message.json');

    $bot = getInstance(json_decode($file));
    $bot->onMessage(OneStepNotCompletedConversation::class);
    $bot->run();
    $bot->run();
    $bot->run();

    expect($bot->getData('test'))->toBe(4);
});
