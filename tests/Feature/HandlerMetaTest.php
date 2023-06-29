<?php

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;

test('setMeta + getMeta + hasMeta', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->getCurrentHandler())
            ->hasMeta('foo')->toBeTrue()
            ->getMeta('foo')->toBe('bar');

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->setMeta('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('setMetas + removeMeta', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->getCurrentHandler()?->removeMeta('baz');

        expect($bot->getCurrentHandler())
            ->hasMeta('foo')->toBeTrue()
            ->hasMeta('baz')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->setMetas(['foo' => 'bar', 'baz' => 'qux']);

    $bot->hearText('/start')->reply();
});

test('clearMetas', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->getCurrentHandler()?->clearMetas();

        expect($bot->getCurrentHandler())
            ->hasMeta('foo')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->setMeta('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('use meta + macroable', function () {
    Handler::macro('emotions', function (int $happiness, int $sadness) {
        return $this->setMeta('happiness', $happiness)->setMeta('sadness', $sadness);
    });

    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->getCurrentHandler())
            ->getMeta('happiness')->toBe(80)
            ->getMeta('sadness')->toBe(20);

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->emotions(80, 20);

    $bot->hearText('/start')->reply();
});
