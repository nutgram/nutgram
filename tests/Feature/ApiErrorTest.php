<?php

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Testing\FakeNutgram;

it('calls the api error handler', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(403, body: $responseBody),
    ]);

    $bot->onApiError(function ($bot, $e) {
        expect($e->getMessage())->toBe('Forbidden: user is deactivated');
        expect($e)->toBeInstanceOf(TelegramException::class);
    });

    $msg = $bot->sendMessage('hi');

    expect($msg)->toBeNull();
})->with('response_user_deactivated');

it('doesnt call the api error handler when cleared', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(403, body: $responseBody),
    ]);

    $bot->onApiError(function ($bot, $e) {
        expect($e->getMessage())->toBe('Forbidden: user is deactivated');
        expect($e)->toBeInstanceOf(TelegramException::class);
    });

    $bot->clearErrorHandlers(apiError: true);

    $bot->sendMessage('hi');
})->with('response_user_deactivated')->expectException(TelegramException::class);

it('calls the specific api error handler', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(403, body: $responseBody),
    ]);

    $bot->onApiError(function ($bot, $e) {
        throw $e;
    });

    $bot->onApiError('.*deactivated.*', function ($bot, $e) {
        expect($e->getMessage())->toBe('Forbidden: user is deactivated');
        expect($e)->toBeInstanceOf(TelegramException::class);
    });

    $msg = $bot->sendMessage('hi');

    expect($msg)->toBeNull();
})->with('response_user_deactivated');

it('calls the generic api error handler if not matched', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(400, body: $responseBody),
    ]);

    $bot->onApiError(function ($bot, $e) {
        expect($e->getMessage())->toBe('Bad Request: wrong file_id or the file is temporarily unavailable');
        expect($e)->toBeInstanceOf(TelegramException::class);
    });

    $bot->onApiError('.*deactivated.*', function ($bot, $e) {
        throw $e;
    });

    $msg = $bot->sendMessage('hi');

    expect($msg)->toBeNull();
})->with('response_wrong_file_id');

it('throws exception if no handler specified', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(400, body: $responseBody),
    ]);

    $bot->sendMessage('hi');
})->with('response_wrong_file_id')->expectException(TelegramException::class);

it('throws exception if too many requests', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(429, body: $responseBody),
    ]);

    try {
        $bot->sendMessage('hi');
    } catch (TelegramException $e) {
        expect($e)->toBeInstanceOf(TelegramException::class)
            ->getMessage()->toBe('Too Many Requests: retry after 14')
            ->getCode()->toBe(429)
            ->getParameters()->toBe(['retry_after' => 14])
            ->getParameter('retry_after')->toBe(14)
            ->hasParameter('retry_after')->toBeTrue()
            ->hasParameter('foo')->toBeFalse();
    }
})->with('too_many_requests');

it('redacts bot token when there is a connectexception', function () {
    $bot = Nutgram::fake(
        responses: [
            new ConnectException(
                'cURL error 6: Could not resolve host: api.telegram.org (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.telegram.org/bot'.FakeNutgram::TOKEN.'/getUpdates',
                new Request('GET', 'https://api.telegram.org/bot'.FakeNutgram::TOKEN.'/sendMessage')
            )
        ],
    );

    try {
        $bot->sendMessage('hello');
    } catch (ConnectException $e) {
        expect($e->getMessage())->not->toContain(FakeNutgram::TOKEN);
    }
});
