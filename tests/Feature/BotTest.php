<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getUpdateMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearUpdateType(UpdateTypes::MESSAGE, ['text' => '/testing', 'from' => ['username' => 'XD']])
        ->willReceivePartial(['text' => 'aaa'])
        ->willReceivePartial(['chat' => ['id' => 123]]);

    $bot->onCommand('testing', function (Nutgram $bot) {
        $message = $bot->sendMessage('test');

        expect($bot->user()->username)->toBe('XD');

        expect($message->text)->toBe('aaa');

        $message = $bot->sendMessage('sos');

        expect($message->chat->id)->toBe(123);
    });

    $bot->fireUp()
        ->assertApiMethodCalled('sendMessage', 2)
        ->assertApiRequestContains('sendMessage', 'test')
        ->assertApiRequestContains('sendMessage', 'sos', 1);
});
