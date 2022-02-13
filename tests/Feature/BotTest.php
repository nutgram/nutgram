<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getUpdateMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function () {

//    $bot = Nutgram::fake()
//        ->withUpdate()
//        ->withResponse();
//
//    $bot->sendMessage('gne');
//
//    $bot->assertSendMessageCalled();
});
