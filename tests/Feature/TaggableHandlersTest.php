<?php

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;

test('setMeta + getMeta + hasMeta', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->getCurrentHandler())
            ->hasTag('foo')->toBeTrue()
            ->getTag('foo')->toBe('bar');

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tag('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('setMetas + removeMeta', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->getCurrentHandler()?->removeTag('baz');

        expect($bot->getCurrentHandler())
            ->hasTag('foo')->toBeTrue()
            ->hasTag('baz')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tags(['foo' => 'bar', 'baz' => 'qux']);

    $bot->hearText('/start')->reply();
});

test('clearMetas', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->getCurrentHandler()?->clearTags();

        expect($bot->getCurrentHandler())
            ->hasTag('foo')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tag('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('use meta + macroable', function () {
    Handler::macro('emotions', function (int $happiness, int $sadness) {
        return $this
            ->tag('happiness', $happiness)
            ->tag('sadness', $sadness);
    });

    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->getCurrentHandler())
            ->getTag('happiness')->toBe(80)
            ->getTag('sadness')->toBe(20);

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->emotions(80, 20);

    $bot->hearText('/start')->reply();
});
