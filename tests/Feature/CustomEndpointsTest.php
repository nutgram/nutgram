<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Limits;

it('sends chunked text message', function () {
    $textOriginal = str_repeat('a', Limits::TEXT_LENGTH + 1);
    $textChunk1 = str_repeat('a', Limits::TEXT_LENGTH);
    $textChunk2 = 'a';

    $bot = Nutgram::fake()
        ->willReceivePartial(['text' => $textChunk1])
        ->willReceivePartial(['text' => $textChunk2]);

    $messages = $bot->sendChunkedMessage($textOriginal);

    expect($messages)
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($message) => $message->toHaveProperty('text', $textChunk1),
            fn ($message) => $message->toHaveProperty('text', $textChunk2),
        );
});
