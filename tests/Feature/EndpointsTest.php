<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Limits;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;

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

it('downloads a file', function ($update) {
    $bot = Nutgram::fake($update, [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => [
                'file_id' => $update->message->document->file_id,
                'file_unique_id' => $update->message->document->file_unique_id,
                'file_size' => $update->message->document->file_size,
                'file_path' => 'bd63e83a-cebc-4a99-aa52-e9f76aca4f37.pdf',
            ],
        ])),
        new Response(200, body: 'ok'),
    ]);

    $bot->onMessageType(MessageTypes::DOCUMENT, function (Nutgram $bot) {
        $document = $bot->message()->document;
        $file = $bot->getFile($document->file_id);

        $response = $bot->downloadFile($file, __DIR__."/".$document->file_name);

        expect($response)->toBeTrue();
    });

    $bot->onException(function (Nutgram $bot, $e) {
        $bot->setData('caught_exception', true);
    });

    $bot->run();

    expect(file_exists(__DIR__."/".$update->message->document->file_name))->toBeTrue();
    expect($bot->getData('caught_exception', false))->toBeFalse();

    if (file_exists(__DIR__."/".$update->message->document->file_name)) {
        unlink(__DIR__."/".$update->message->document->file_name);
    }
})->with('document');

it('calls getUpdates method', function () {
    $bot = Nutgram::fake(responses: [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => [
                json_decode(file_get_contents(__DIR__.'/../Updates/message.json'), true),
                json_decode(file_get_contents(__DIR__.'/../Updates/message.json'), true),
            ],
        ])),
    ]);

    expect($bot->getUpdates())
        ->toBeArray()
        ->toHaveCount(2)
        ->sequence(
            fn ($update) => $update->toBeInstanceOf(Update::class),
            fn ($update) => $update->toBeInstanceOf(Update::class),
        );
});

it('calls setWebhook method', function () {
    $bot = Nutgram::fake(responses: [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => true,
        ])),
    ]);

    expect($bot->setWebhook('https://example.com'))->toBeTrue();
});

it('calls deleteWebhook method', function () {
    $bot = Nutgram::fake(responses: [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => true,
        ])),
    ]);

    expect($bot->deleteWebhook())->toBeTrue();
});

it('calls getWebhookInfo method', function () {
    $info = [
        'url' => 'https://example.com',
        'has_custom_certificate' => false,
        'pending_update_count' => 0,
        'ip_address' => '1.2.3.4',
        'last_error_date' => null,
        'last_error_message' => null,
        'last_synchronization_error_date' => null,
        'max_connections' => 50,
        'allowed_updates' => [],
    ];

    $bot = Nutgram::fake(responses: [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => $info,
        ])),
    ]);

    expect($bot->getWebhookInfo())
        ->toBeInstanceOf(WebhookInfo::class)
        ->url->toBe($info['url'])
        ->has_custom_certificate->toBe($info['has_custom_certificate'])
        ->pending_update_count->toBe($info['pending_update_count'])
        ->ip_address->toBe($info['ip_address'])
        ->last_error_date->toBe($info['last_error_date'])
        ->last_error_message->toBe($info['last_error_message'])
        ->last_synchronization_error_date->toBe($info['last_synchronization_error_date'])
        ->max_connections->toBe($info['max_connections'])
        ->allowed_updates->toBe($info['allowed_updates']);
});
