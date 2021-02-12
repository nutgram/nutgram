<?php

it('call the message handler with a middleware', function ($update) {
    $bot = getInstance($update);

    $count = 0;

    $bot->onMessage(function ($bot) use (&$count) {
        $count++;
    })->middleware(function ($bot, $next) use (&$count) {
        $count++;
        $next($bot);
    });

    $bot->run();

    expect($count)->toBe(2);
})->with('message');
