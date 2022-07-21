<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Limits;

it('throws exception when text is too long', function ($responseBody) {
    $textOriginal = str_repeat('a', Limits::TEXT_LENGTH + 1);

    /** @var Nutgram $bot */
    $bot = Nutgram::fake(responses: [
        new Response(400, body: $responseBody),
    ]);

    $bot->onApiError(function ($bot, $e) {
        expect($e->getMessage())->toBe('Bad Request: message is too long');
        expect($e)->toBeInstanceOf(TelegramException::class);
    });

    $messages = $bot->sendMessage($textOriginal);

    expect($messages)->toBeNull();
})->with('too_long');

it('chunks long text message', function () {
    $textOriginal = str_repeat('a', Limits::TEXT_LENGTH + 1);
    $textChunk1 = str_repeat('a', Limits::TEXT_LENGTH);
    $textChunk2 = 'a';

    /** @var Nutgram $bot */
    $bot = Nutgram::fake(config: ['split_long_messages' => true])
        ->willReceivePartial(['text' => $textChunk1])
        ->willReceivePartial(['text' => $textChunk2]);

    $messages = $bot->sendMessage($textOriginal);

    expect($messages)
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($message) => $message->toHaveProperty('text', $textChunk1),
            fn ($message) => $message->toHaveProperty('text', $textChunk2),
        );
});
