<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getUpdateMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function ($update) {
    $bot = Nutgram::fake()
        ->hears(UpdateTypes::MESSAGE)
        ->willReceivePartial(['text' => 'aaa'])
        ->willReceivePartial(['chat' => ['id' => 123]]);

    $bot->onMessage(function (Nutgram $bot) {
        $message = $bot->sendMessage('test');

        expect($message->text)->toBe('aaa');

        $message = $bot->sendMessage('sos');

        expect($message->chat->id)->toBe(123);
    });

    $bot->run();

    $bot->assertApiMethodCalled('sendMessage', 2)
        ->assertApiRequestContains('sendMessage', 'test')
        ->assertApiRequestContains('sendMessage', 'sos', 1);
})->with('message');
