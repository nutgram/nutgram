<?php

use SergiX44\Nutgram\Nutgram;

it('does not disable handler', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('hello');
    })->unless(false);

    $bot->hearText('/start')
        ->reply()
        ->assertReplyText('hello');
});

it('does not run disabled handler', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('hello');
    })->unless(true);

    $bot->hearText('/start')
        ->reply()
        ->assertNoReply();
});

it('does not run disabled handler inside group', function () {
    $bot = Nutgram::fake();

    $bot->group(function (Nutgram $bot) {
        $bot->onCommand('start', function (Nutgram $bot) {
            $bot->sendMessage('hello');
        });
    })->unless(true);

    $bot->hearText('/start')
        ->reply()
        ->assertNoReply();
});
