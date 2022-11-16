<?php

use SergiX44\Nutgram\Nutgram;

it('calls onText() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onCommand() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('command');

it('calls onCommand() handler with different tags', function ($update, $valid) {
    $bot = Nutgram::fake($update, config: ['bot_name' => 'foo']);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called', false))->toBe($valid);
})->with('command_tags');

it('calls onAnimation() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAnimation(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('animation');

it('calls onAudio() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onAudio(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('audio');

it('calls onSuccessfulPayment() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPayment(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onSuccessfulPaymentPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPaymentPayload('thedata', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onForumTopicCreated handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicCreated(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_created');

it('calls onForumTopicClosed handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicClosed(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_closed');

it('calls onForumTopicReopened handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onForumTopicReopened(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('forum_topic_reopened');
