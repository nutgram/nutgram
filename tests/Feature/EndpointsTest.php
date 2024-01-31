<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Limits;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputSticker;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Testing\FormDataParser;

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

    $bot->onMessageType(MessageType::DOCUMENT, function (Nutgram $bot) {
        $document = $bot->message()->document;
        $file = $bot->getFile($document->file_id);

        $response = $bot->downloadFile($file, __DIR__."/".$document->file_name);

        expect($response)->toBeTrue();
    });

    $bot->onException(function (Nutgram $bot, $e) {
        $bot->set('caught_exception', true);
    });

    $bot->run();

    expect(file_exists(__DIR__."/".$update->message->document->file_name))->toBeTrue();
    expect($bot->get('caught_exception', false))->toBeFalse();

    if (file_exists(__DIR__."/".$update->message->document->file_name)) {
        unlink(__DIR__."/".$update->message->document->file_name);
    }
})->with('document');

it('calls getUpdates method', function () {
    $bot = Nutgram::fake(responses: [
        new Response(200, body: json_encode([
            'ok' => true,
            'result' => [
                json_decode(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'), true),
                json_decode(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'), true),
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

it('uploads a file with attach:// logic', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $message = $bot->sendPhoto(
            photo: InputFile::make(fopen('php://temp', 'rb'), 'photoA.jpg'),
            caption: 'A',
        );

        $bot->editMessageMedia(
            media: InputMediaPhoto::make(
                media: InputFile::make(fopen('php://temp', 'rb'), 'photoB.jpg'),
                caption: 'B',
            ),
            chat_id: $message->chat->id,
            message_id: $message->message_id
        );
    });

    $bot
        ->hearText('/start')
        ->reply()
        ->assertReply('sendPhoto', [
            'caption' => 'A',
        ], 0)
        ->assertReply('editMessageMedia', [
            'media' => '{"type":"photo","media":"attach:\\/\\/photoB.jpg","caption":"B"}',
        ], 1)
        ->assertRaw(function (Request $request) {
            $photo = FormDataParser::parse($request)->files['photoB.jpg'];
            return $photo->getName() === 'photoB.jpg';
        }, 1);
});

it('creates a new sticker set using InputFile', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $file = InputFile::make(
            resource: fopen('php://temp', 'rb'),
            filename: 'sticker.png',
        );

        $sticker = InputSticker::make(
            sticker: $file,
            emoji_list: ['🤔'],
        );

        $bot->createNewStickerSet(
            name: 'MyPack_by_NutgramBot',
            title: 'MyPack By Nutgram',
            stickers: [
                $sticker
            ],
            sticker_format: 'static',
            sticker_type: 'regular',
        );
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $payload) {
        expect($payload['multipart'])->sequence(
            fn ($x) => $x
                ->name->toBe('user_id')
                ->contents->toBe(123),
            fn ($x) => $x
                ->name->toBe('name')
                ->contents->toBe('MyPack_by_NutgramBot'),
            fn ($x) => $x
                ->name->toBe('title')
                ->contents->toBe('MyPack By Nutgram'),
            fn ($x) => $x
                ->name->toBe('sticker_format')
                ->contents->toBe('static'),
            fn ($x) => $x
                ->name->toBe('sticker_type')
                ->contents->toBe('regular'),
            fn ($x) => $x
                ->name->toBe('sticker.png')
                ->filename->toBe('sticker.png'),
            fn ($x) => $x
                ->name->toBe('stickers')
                ->contents->toBe('[{"sticker":"attach:\/\/sticker.png","emoji_list":["\ud83e\udd14"]}]'),
        );
    });

    $bot
        ->setCommonUser(User::make(123, false, 'Foo'))
        ->hearText('/start')
        ->reply();
});

it('creates a new sticker set using Url', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $sticker = InputSticker::make(
            sticker: 'https://example.com/sticker.png',
            emoji_list: ['🤔'],
        );

        $bot->createNewStickerSet(
            name: 'MyPack_by_NutgramBot',
            title: 'MyPack By Nutgram',
            stickers: [
                $sticker
            ],
            sticker_format: 'static',
            sticker_type: 'regular',
        );
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $payload) {
        expect($payload['multipart'])->sequence(
            fn ($x) => $x
                ->name->toBe('user_id')
                ->contents->toBe(123),
            fn ($x) => $x
                ->name->toBe('name')
                ->contents->toBe('MyPack_by_NutgramBot'),
            fn ($x) => $x
                ->name->toBe('title')
                ->contents->toBe('MyPack By Nutgram'),
            fn ($x) => $x
                ->name->toBe('sticker_format')
                ->contents->toBe('static'),
            fn ($x) => $x
                ->name->toBe('sticker_type')
                ->contents->toBe('regular'),
            fn ($x) => $x
                ->name->toBe('stickers')
                ->contents->toBe('[{"sticker":"https:\/\/example.com\/sticker.png","emoji_list":["\ud83e\udd14"]}]'),
        );
    });

    $bot
        ->setCommonUser(User::make(123, false, 'Foo'))
        ->hearText('/start')
        ->reply();
});

it('add sticker to set using InputFile', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $file = InputFile::make(
            resource: fopen('php://temp', 'rb'),
            filename: 'sticker.png',
        );

        $sticker = InputSticker::make(
            sticker: $file,
            emoji_list: ['🤔'],
        );

        $bot->addStickerToSet(
            name: 'MyPack_by_NutgramBot',
            sticker: $sticker,
        );
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $payload) {
        expect($payload['multipart'])
            ->sequence(
                fn ($x) => $x
                    ->name->toBe('user_id')
                    ->contents->toBe(123),
                fn ($x) => $x
                    ->name->toBe('name')
                    ->contents->toBe('MyPack_by_NutgramBot'),
                fn ($x) => $x
                    ->name->toBe('sticker.png')
                    ->filename->toBe('sticker.png'),
                fn ($x) => $x
                    ->name->toBe('sticker')
                    ->contents->toBe('{"sticker":"attach:\/\/sticker.png","emoji_list":["\ud83e\udd14"]}'),
            );
    });

    $bot
        ->setCommonUser(User::make(123, false, 'Foo'))
        ->hearText('/start')
        ->reply();
});

it('add sticker to set using Url', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $sticker = InputSticker::make(
            sticker: 'https://example.com/sticker.png',
            emoji_list: ['🤔'],
        );

        $bot->addStickerToSet(
            name: 'MyPack_by_NutgramBot',
            sticker: $sticker,
        );
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $payload) {
        expect($payload['multipart'])
            ->sequence(
                fn ($x) => $x
                    ->name->toBe('user_id')
                    ->contents->toBe(123),
                fn ($x) => $x
                    ->name->toBe('name')
                    ->contents->toBe('MyPack_by_NutgramBot'),
                fn ($x) => $x
                    ->name->toBe('sticker')
                    ->contents->toBe('{"sticker":"https:\/\/example.com\/sticker.png","emoji_list":["\ud83e\udd14"]}'),
            );
    });

    $bot
        ->setCommonUser(User::make(123, false, 'Foo'))
        ->hearText('/start')
        ->reply();
});

it('sends a media group', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $payload) {
        expect($payload['multipart'])
            ->sequence(
                fn ($x) => $x
                    ->name->toBe('photoA.jpg')
                    ->filename->toBe('photoA.jpg')
                    ->contents->toBeResource(),
                fn ($x) => $x
                    ->name->toBe('photoB.jpg')
                    ->filename->toBe('photoB.jpg')
                    ->contents->toBeResource(),
                fn ($x) => $x
                    ->name->toBe('media')
                    ->contents->toBe('[{"type":"photo","media":"attach:\/\/photoA.jpg","caption":"150"},{"type":"photo","media":"attach:\/\/photoB.jpg","caption":"200"}]'),
            );
    });

    $bot->sendMediaGroup([
        InputMediaPhoto::make(
            media: InputFile::make(fopen('php://temp', 'rb'), 'photoA.jpg'),
            caption: '150',
        ),
        InputMediaPhoto::make(
            media: InputFile::make(fopen('php://temp', 'rb'), 'photoB.jpg'),
            caption: '200',
        ),
    ]);
});

it('serializes extra properties to array', function () {
    $chat = new \SergiX44\Nutgram\Telegram\Types\Chat\Chat(Nutgram::fake());
    $chat->bio = 'test';
    $chat->type = \SergiX44\Nutgram\Telegram\Properties\ChatType::SUPERGROUP;
    $chat->notExists = 123;

    $array = $chat->toArray();
    expect($array)->toBe([
        'type' => 'supergroup',
        'bio' => 'test',
        'notExists' => 123,
    ]);
});
