<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

it('calls middleware() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->setData('called', true);
        $next($bot);
    });

    $bot->onText('Ciao', function (Nutgram $bot) {
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onException() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onException() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(DivisionByZeroError::class, function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onApiError() handler', function ($update) {
    $bot = Nutgram::fake($update, [
        new Response(
            status: 400,
            body: '{"ok":false,"error_code":400,"description":"Bad Request: message is not modified"}'
        ),
    ]);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onApiError() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update, [
        new Response(
            status: 400,
            body: '{"ok":false,"error_code":400,"description":"Bad Request: message is not modified"}'
        ),
    ]);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->onApiError('.*not modified.*', function (Nutgram $bot, TelegramException $exception) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallback() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallback(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallbackOn() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallbackOn(UpdateTypes::MESSAGE, function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallbackOn() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallbackOn('foo', '/test', function (Nutgram $bot) {
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message')->throws(InvalidArgumentException::class, 'The parameter "type" is not a valid update type.');

it('calls clearErrorHandlers() method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->clearErrorHandlers();

    $bot->run();

    expect($bot->getData('called'))->toBeNull();
})->with('message')->throws(DivisionByZeroError::class);
