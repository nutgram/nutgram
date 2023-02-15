<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Tests\Adapters\TestCache;


beforeEach(function () {
    $this->bot = Nutgram::fake(config: [
        'cache' => new TestCache(),
    ]);

    $this->bot->setCommonUser(User::make(
        id: 123456789,
        is_bot: false,
        first_name: 'Tony',
        last_name: 'Stark',
        username: 'IronMan',
        language_code: 'en',
    ));

    $this->bot->setCommonChat(Chat::make(
        id: 123456789,
        type: 'private',
        username: 'IronMan',
        first_name: 'Tony',
        last_name: 'Stark',
    ));

    $this->bot->onCommand('start', function (Nutgram $bot) {
        $bot->setUserData('credits', 1);
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });

    $this->bot->onCommand('credits', function (Nutgram $bot) {
        $credits = $bot->getUserData('credits', default: 0);
        $bot->sendMessage("Credits: $credits");
    });
});

it('sends /start command', function () {
    $this->bot
        ->hearText('/start')
        ->reply()
        ->assertReplyText('Credits: 1');
});

it('sends /credits command', function () {
    $this->bot
        ->hearText('/credits')
        ->reply()
        ->assertReplyText('Credits: 1');
});
