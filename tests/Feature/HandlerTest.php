<?php

it('call the message handler', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'A';
    });

    $bot->run();

    expect($test)->toBe('A');
})->with('message');

it('call the message handler with a middleware', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'B';
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'A';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('AB');
})->with('message');

it('call the message handler with multiple middlewares', function ($update) {
    $bot = getInstance($update);

    $test = '';

    $bot->middleware(function ($bot, $next) use (&$test) {
        $test .= 'A';
        $next($bot);
    });

    $bot->onMessage(function ($bot) use (&$test) {
        $test .= 'D';
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'C';
        $next($bot);
    })->middleware(function ($bot, $next) use (&$test) {
        $test .= 'B';
        $next($bot);
    });

    $bot->run();

    expect($test)->toBe('ABCD');
})->with('message');

it('call the fallback if not match any listener', function ($update) {
    $bot = getInstance($update);

    $bot->onText('Cia', function () {
        throw new Exception();
    });

    $bot->fallback(function ($bot) {
        expect($bot)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
    });

    $bot->run();
})->with('message');
