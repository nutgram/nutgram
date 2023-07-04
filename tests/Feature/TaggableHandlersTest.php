<?php

use SergiX44\Nutgram\Handlers\Handler;
use SergiX44\Nutgram\Handlers\HandlerGroup;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

test('setTag + getTag + hasTag', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->currentHandler())
            ->hasTag('foo')->toBeTrue()
            ->getTag('foo')->toBe('bar');

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tag('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('setTags + removeTag', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->currentHandler()?->removeTag('baz');

        expect($bot->currentHandler())
            ->hasTag('foo')->toBeTrue()
            ->hasTag('baz')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tags(['foo' => 'bar', 'baz' => 'qux']);

    $bot->hearText('/start')->reply();
});

test('clearTags', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->currentHandler()?->clearTags();

        expect($bot->currentHandler())
            ->hasTag('foo')->toBeFalse();

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->tag('foo', 'bar');

    $bot->hearText('/start')->reply();
});

test('getTags', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->currentHandler())
            ->hasTag('foo')->toBeTrue();

        $next($bot);
    });

    $bot->registerCommand(new class extends Command {
        protected string $command = 'start';

        public function getTags(): array
        {
            return ['foo' => 'bar'];
        }

        public function handle(Nutgram $bot): void
        {
            $bot->sendMessage('Hello');
        }
    });

    $bot->hearText('/start')->reply();
});

test('use tag + macroable', function () {
    Handler::macro('emotions', function (int $happiness, int $sadness) {
        return $this
            ->tag('happiness', $happiness)
            ->tag('sadness', $sadness);
    });

    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->currentHandler())
            ->getTag('happiness')->toBe(80)
            ->getTag('sadness')->toBe(20);

        $next($bot);
    });

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello');
    })->emotions(80, 20);

    $bot->hearText('/start')->reply();
});


test('set tags using group', function () {
    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->currentHandler())
            ->getTag('tag1')->toBe('foo')
            ->getTag('tag2')->toBe('bar');

        $next($bot);
    });

    $bot->group(function (Nutgram $bot) {
        $bot->onCommand('start', function (Nutgram $bot) {
            $bot->sendMessage('Hello!');
        })->tag('tag2', 'bar');
    })->tag('tag1', 'foo');

    $bot->hearText('/start')->reply();
});

test('set tags + macroable using group', function () {
    HandlerGroup::macro('emotions', function (int $happiness, int $sadness) {
        return $this->tag('happiness', $happiness)->tag('sadness', $sadness);
    });

    $bot = Nutgram::fake();

    $bot->middleware(function (Nutgram $bot, $next) {
        expect($bot->currentHandler())
            ->getTag('happiness')->toBe(80)
            ->getTag('sadness')->toBe(20)
            ->getTag('tag1')->toBe('foo');

        $next($bot);
    });
    $bot->group(function (Nutgram $bot) {
        $bot->onCommand('start', function (Nutgram $bot) {
            $bot->sendMessage('Hello');
        })->tag('tag1', 'foo');
    })->emotions(80, 20);

    $bot->hearText('/start')->reply();
});
