<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

it('calls middleware() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->set('called', true);
        $next($bot);
    });

    $bot->onText('Ciao', function (Nutgram $bot) {
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls onException() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls onException() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(DivisionByZeroError::class, function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
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
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
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
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls fallback() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallback(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls fallbackOn() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallbackOn(UpdateType::MESSAGE, function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls clearErrorHandlers() method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->clearErrorHandlers();

    $bot->run();

    expect($bot->get('called'))->toBeNull();
})->with('message')->throws(DivisionByZeroError::class);

it('calls onUpdate() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onUpdate(function (Nutgram $bot) {
        $bot->set('onUpdate called', true);
    });

    $bot->onSticker(function (Nutgram $bot) {
        $bot->set('onSticker called', true);
    });

    $bot->run();

    expect($bot)
        ->get('onUpdate called', false)->toBeTrue()
        ->get('onSticker called', false)->toBeTrue();
})->with('sticker');

it('calls beforeApiRequest() method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('foo', function (Nutgram $bot) {
        $bot->sendMessage(
            text: 'bar',
            chat_id: 123,
        );
    });

    $bot->beforeApiRequest(function (Nutgram $bot, $request, $endpoint) {
        expect($request['json'])
            ->text->toBe('bar')
            ->chat_id->toBe(123)
            ->and($endpoint)->toBe('sendMessage');
        return $request;
    });

    $bot->hearText('foo')
        ->reply()
        ->assertReplyText('bar');
})->with('text');

it('calls afterApiRequest() method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('foo', function ($bot) {
        $bot->sendMessage(
            text: 'bar',
            chat_id: 123,
        );
    });

    $bot->afterApiRequest(function (Nutgram $bot, $request) {
        expect($request)
            ->ok->toBeTrue()
            ->result->toBeInstanceOf(stdClass::class);
        return $request;
    });

    $bot->hearText('foo')
        ->reply()
        ->assertReplyText('bar');
})->with('text');
