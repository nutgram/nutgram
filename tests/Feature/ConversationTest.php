<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Feature\Conversations\ConversationWithClosing;
use SergiX44\Nutgram\Tests\Feature\Conversations\ConversationWithClosingMultipleSteps;
use SergiX44\Nutgram\Tests\Feature\Conversations\ConversationWithDefault;
use SergiX44\Nutgram\Tests\Feature\Conversations\OneStepNotCompletedConversation;
use SergiX44\Nutgram\Tests\Feature\Conversations\TwoStepConversation;

it('calls the conversation steps', function ($update) {
    $bot = getInstance($update);
    $bot->onMessage(TwoStepConversation::class);
    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('calls the default conversation step', function ($update) {
    $bot = getInstance($update);
    $bot->onMessage(ConversationWithDefault::class);
    $bot->run();

    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('calls the closing handler', function ($update) {
    $bot = getInstance($update);
    $bot->onMessage(ConversationWithClosing::class);
    $bot->run();

    expect($bot->getData('test'))->toBe(2);
})->with('message');

it('calls the closing handler with multiple steps', function ($update) {
    $bot = getInstance($update);
    $bot->onMessage(ConversationWithClosingMultipleSteps::class);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(3);
})->with('message');

it('calls the same handler if not end or next step called', function ($update) {
    $bot = getInstance($update);
    $bot->onMessage(OneStepNotCompletedConversation::class);
    $bot->run();
    $bot->run();
    $bot->run();

    expect($bot->getData('test'))->toBe(4);
})->with('message');

it('calls the conversation steps without class', function ($update) {
    $bot = getInstance($update);

    $bot->onMessage('firstStep');

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
})->with('message');

function firstStep(Nutgram $bot)
{
    $bot->setData('test', 1);
    $bot->stepConversation('secondStep');
}

function secondStep(Nutgram $bot)
{
    $bot->setData('test', 2);
    $bot->endConversation();
}

it('works with inline conversations', function ($update) {
    $bot = getInstance($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->setData('test', 1);

        $bot->stepConversation(function (Nutgram $bot) {
            $bot->setData('test', 2);
            $bot->endConversation();
        });
    });

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
    <<<<
    <<< HEAD
})->with('message');
=======
});
>>>>>>> 475af68 (Apply fixes from StyleCI)
