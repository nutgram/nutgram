<?php

it('call the message handler', function ($update) {
    $bot = getInstance($update);

    $bot->onMessage(function (\SergiX44\Nutgram\Nutgram $bot) {
        // check the message
    });

    $bot->run();
})->with('message');
