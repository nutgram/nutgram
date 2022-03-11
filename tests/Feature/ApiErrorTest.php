<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

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
