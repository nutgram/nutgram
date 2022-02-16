<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getUpdateMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function ($update) {
    $bot = Nutgram::fake()
        ->hears($update)
        ->willReceive(['text' => 'test'])
        ->willReceive(['text' => 'test']);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('test');
        $bot->sendMessage('sos');
    });

    $bot->run();

    $bot->assertApiMethodCalled('sendMessage', 2)
        ->assertApiRequestContains('sendMessage', 'test')
        ->assertApiRequestContains('sendMessage', 'sos', 1);
})->with('message');
