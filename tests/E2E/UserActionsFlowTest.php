<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

it('cannot remember the user', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->setUserData('credits', 1);
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });

    $bot->onCommand('credits', function (Nutgram $bot) {
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });

    $bot
        ->hearText('/start')
        ->reply()
        ->assertReplyText('Credits: 1');

    $bot
        ->hearText('/credits')
        ->reply()
        ->assertReplyText('Credits: 0');
});

it('can remember the user', function () {
    $bot = Nutgram::fake();

    $bot->setCommonUser(User::make(
        id: 123456789,
        is_bot: false,
        first_name: 'Tony',
        last_name: 'Stark',
        username: 'IronMan',
        language_code: 'en',
    ));

    $bot->setCommonChat(Chat::make(
        id: 123456789,
        type: 'private',
        username: 'IronMan',
        first_name: 'Tony',
        last_name: 'Stark',
    ));

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->setUserData('credits', 1);
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });

    $bot->onCommand('credits', function (Nutgram $bot) {
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });

    $bot
        ->hearText('/start')
        ->reply()
        ->assertReplyText('Credits: 1');

    $bot
        ->hearText('/credits')
        ->reply()
        ->assertReplyText('Credits: 1');
});
