<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;

beforeEach(function () {
    $this->user = User::make(
        id: 123456,
        is_bot: false,
        first_name: 'John',
        last_name: 'Doe',
        username: 'johndoe',
        language_code: 'en'
    );
});

it('can throttle global handlers', function () {
    $bot = Nutgram::fake();
    $bot->throttle(1, 10);

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    });

    $bot->setCommonUser($this->user);

    $bot->hearText('/start')->reply()->assertReplyText('Hello');
    $bot->hearText('/start')->reply()->assertReplyText("Too many messages sent!\nYou may try again in 10 seconds.");
});

it('can throttle specific handlers', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->throttle(1, 10);

    $bot->setCommonUser($this->user);

    $bot->hearText('/start')->reply()->assertReplyText('Hello');
    $bot->hearText('/start')->reply()->assertReplyText("Too many messages sent!\nYou may try again in 10 seconds.");
});

it('can throttle using different message', function () {
    Nutgram::$throttleMessageClosure = function (Nutgram $bot, int $seconds) {
        $bot->sendMessage("Retry again in $seconds seconds.");
    };

    $bot = Nutgram::fake();
    $bot->throttle(1, 10);

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    });

    $bot->setCommonUser($this->user);

    $bot->hearText('/start')->reply()->assertReplyText('Hello');
    $bot->hearText('/start')->reply()->assertReplyText("Retry again in 10 seconds.");
});
