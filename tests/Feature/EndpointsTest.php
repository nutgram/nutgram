<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Limits;
use SergiX44\Nutgram\Telegram\Properties\Currency;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\StickerFormat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatAdministratorRights;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Input\InputProfilePhotoAnimated;
use SergiX44\Nutgram\Telegram\Types\Input\InputProfilePhotoStatic;
use SergiX44\Nutgram\Telegram\Types\Input\InputSticker;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Poll\InputPollOption;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockCollage;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockList;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockListItem;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockPhoto;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichBlock\InputRichBlockVideo;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichMessage;
use SergiX44\Nutgram\Telegram\Types\RichMessage\InputRichMessageMedia;
use SergiX44\Nutgram\Telegram\Types\SuggestedPost\SuggestedPostParameters;
use SergiX44\Nutgram\Telegram\Types\SuggestedPost\SuggestedPostPrice;
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
            format: StickerFormat::STATIC,
            emoji_list: ['🤔'],
        );

        $bot->createNewStickerSet(
            name: 'MyPack_by_NutgramBot',
            title: 'MyPack By Nutgram',
            stickers: [
                $sticker
            ],
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
                ->name->toBe('sticker_type')
                ->contents->toBe('regular'),
            fn ($x) => $x
                ->name->toBe('sticker.png')
                ->filename->toBe('sticker.png'),
            fn ($x) => $x
                ->name->toBe('stickers')
                ->contents->toBe('[{"sticker":"attach:\/\/sticker.png","format":"static","emoji_list":["\ud83e\udd14"]}]'),
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
            format: StickerFormat::STATIC,
            emoji_list: ['🤔'],
        );

        $bot->createNewStickerSet(
            name: 'MyPack_by_NutgramBot',
            title: 'MyPack By Nutgram',
            stickers: [
                $sticker
            ],
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
                ->name->toBe('sticker_type')
                ->contents->toBe('regular'),
            fn ($x) => $x
                ->name->toBe('stickers')
                ->contents->toBe('[{"sticker":"https:\/\/example.com\/sticker.png","format":"static","emoji_list":["\ud83e\udd14"]}]'),
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
            format: StickerFormat::STATIC,
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
                    ->contents->toBe('{"sticker":"attach:\/\/sticker.png","format":"static","emoji_list":["\ud83e\udd14"]}'),
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
            format: StickerFormat::STATIC,
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
                    ->contents->toBe('{"sticker":"https:\/\/example.com\/sticker.png","format":"static","emoji_list":["\ud83e\udd14"]}'),
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
                    ->contents->toBeInstanceOf(StreamInterface::class),
                fn ($x) => $x
                    ->name->toBe('photoB.jpg')
                    ->filename->toBe('photoB.jpg')
                    ->contents->toBeInstanceOf(StreamInterface::class),
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

it('calls sendMessage with the right message_thread_id', function () {
    $bot = Nutgram::fake();

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('Hello thread!');
    });

    $bot
        ->hearMessage([
            'text' => 'Hello',
            'message_thread_id' => 66,
            'is_topic_message' => true,
        ])
        ->reply()
        ->assertReplyMessage([
            'text' => 'Hello thread!',
            'message_thread_id' => 66,
        ]);
});

it('calls sendMessage with the right business_connection_id', function () {
    $bot = Nutgram::fake();

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('Hello thread!');
    });

    $bot
        ->hearMessage([
            'text' => 'Hello',
            'business_connection_id' => 'biz007',
        ])
        ->reply()
        ->assertReplyMessage([
            'text' => 'Hello thread!',
            'business_connection_id' => 'biz007',
        ]);
});

it('calls pinChatMessage method', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $result = $bot->pinChatMessage(123, 321);

        expect($result)->toBeTrue();
    });

    $bot
        ->hearText('/start')
        ->willReceive(true)
        ->reply()
        ->assertReply('pinChatMessage');
});

it('calls getMyDefaultAdministratorRights', function ($responseBody) {
    $bot = Nutgram::fake(responses: [
        new Response(200, body: $responseBody),
    ]);

    $bot->onCommand('start', function (Nutgram $bot) {
        $rights = $bot->getMyDefaultAdministratorRights();

        expect($rights)->toBeInstanceOf(ChatAdministratorRights::class);
    });

    $bot->hearText('/start')->reply();
})->with('response_ChatAdministratorRights');

it('sends multiple medias via sendMediaGroup', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)->toHaveKeys(['chat_id', 'media', 'photoA.jpg', 'photoB.jpg', 'video.jpg']);
    });

    $bot->sendMediaGroup(
        media: [
            InputMediaPhoto::make(
                media: InputFile::make(fopen('php://temp', 'rb'), 'photoA.jpg'),
            ),
            InputMediaVideo::make(
                media: InputFile::make(fopen('php://temp', 'rb'), 'video.jpg'),
                thumbnail: 'https://i.ytimg.com/vi/fQ1BU25IogA/maxresdefault.jpg',
                cover: InputFile::make(fopen('php://temp', 'rb'), 'photoB.jpg'),
            ),
        ],
        chat_id: 123,
    );
});

it('serializes suggested post parameters in multipart requests', function (SuggestedPostParameters $parameters, string $expected) {
    $bot = Nutgram::fake();

    $bot->sendRichMessage(
        rich_message: new InputRichMessage(html: '<p>Hello</p>'),
        chat_id: 123,
        suggested_post_parameters: $parameters,
    );

    $request = $bot->getRequestHistory()[0]['request'];
    expect($request->getHeaderLine('Content-Type'))->toStartWith('multipart/form-data;')
        ->and(FormDataParser::parse($request)->params['suggested_post_parameters'])->toBe($expected);
})->with([
    'empty' => [new SuggestedPostParameters(), '{}'],
    'priced' => [
        SuggestedPostParameters::make(price: new SuggestedPostPrice(Currency::XTR, 25)),
        '{"price":{"currency":"XTR","amount":25}}',
    ],
    'scheduled' => [
        SuggestedPostParameters::make(send_date: 2000000000),
        '{"send_date":2000000000}',
    ],
]);

it('uploads business profile photos with serialized metadata', function (string $photoClass, string $filename, array $arguments, array $expected) {
    $bot = Nutgram::fake();
    $resource = fopen('php://temp', 'w+b');
    fwrite($resource, 'profile photo contents');
    rewind($resource);

    $bot->setBusinessAccountProfilePhoto(
        photo: new $photoClass(InputFile::make($resource, $filename), ...$arguments),
        business_connection_id: 'test-connection',
    );

    $request = $bot->getRequestHistory()[0]['request'];
    $data = FormDataParser::parse($request);
    expect($request->getHeaderLine('Content-Type'))->toStartWith('multipart/form-data;')
        ->and(json_decode($data->params['photo'], true, flags: JSON_THROW_ON_ERROR))->toBe($expected)
        ->and($data->files)->toHaveKey($filename)
        ->and((string)$request->getBody())->toContain('profile photo contents');
})->with([
    'static' => [
        InputProfilePhotoStatic::class,
        'avatar.jpg',
        [],
        ['type' => 'static', 'photo' => 'attach://avatar.jpg'],
    ],
    'animated' => [
        InputProfilePhotoAnimated::class,
        'avatar.mp4',
        ['main_frame_timestamp' => 0.5],
        ['type' => 'animated', 'animation' => 'attach://avatar.mp4', 'main_frame_timestamp' => 0.5],
    ],
]);

it('uploads the media referenced by a rich message', function () {
    $bot = Nutgram::fake();

    $media = new InputRichMessageMedia();
    $media->id = 'pic';
    $media->media = InputMediaPhoto::make(
        media: InputFile::make(fopen('php://temp', 'rb'), 'photo.jpg'),
    );

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)
            ->toHaveKeys(['chat_id', 'rich_message', 'photo.jpg'])
            ->and($data['photo.jpg'])->toBeInstanceOf(StreamInterface::class)
            ->and($data['rich_message'])->toContain('attach:\/\/photo.jpg');
    });

    $bot->sendRichMessage(
        rich_message: new InputRichMessage(
            html: '<img src="tg://photo?id=pic">',
            media: [$media],
        ),
        chat_id: 123,
    );
});

it('uploads the media nested inside the blocks of a rich message', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)->toHaveKeys(['chat_id', 'rich_message', 'photo.jpg', 'video.mp4', 'thumb.jpg']);
    });

    $bot->sendRichMessage(
        rich_message: new InputRichMessage(blocks: [
            new InputRichBlockList([
                new InputRichBlockListItem([
                    new InputRichBlockCollage([
                        new InputRichBlockPhoto(InputMediaPhoto::make(
                            media: InputFile::make(fopen('php://temp', 'rb'), 'photo.jpg'),
                        )),
                        new InputRichBlockVideo(InputMediaVideo::make(
                            media: InputFile::make(fopen('php://temp', 'rb'), 'video.mp4'),
                            thumbnail: InputFile::make(fopen('php://temp', 'rb'), 'thumb.jpg'),
                        )),
                    ]),
                ]),
            ]),
        ]),
        chat_id: 123,
    );
});

it('sends a rich message as multipart when there is nothing to upload', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request)
            ->toHaveKey('multipart')
            ->not->toHaveKey('json');

        $data = array_column($request['multipart'], 'contents', 'name');
        expect($data)->toHaveCount(2)->toHaveKeys(['chat_id', 'rich_message'])
            ->and(json_decode($data['rich_message'], true, flags: JSON_THROW_ON_ERROR))
            ->toBe(['blocks' => [['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'file_id']]]]);
    });

    $bot->sendRichMessage(
        rich_message: new InputRichMessage(blocks: [
            new InputRichBlockPhoto(InputMediaPhoto::make(media: 'file_id')),
        ]),
        chat_id: 123,
    );
});

it('uploads the media of a rich message when editing a message', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)->toHaveKeys(['chat_id', 'message_id', 'rich_message', 'photo.jpg']);
    });

    $bot->editMessageText(
        chat_id: 123,
        message_id: 456,
        rich_message: new InputRichMessage(blocks: [
            new InputRichBlockPhoto(InputMediaPhoto::make(
                media: InputFile::make(fopen('php://temp', 'rb'), 'photo.jpg'),
            )),
        ]),
    );
});

it('uploads the media of the poll options', function () {
    $bot = Nutgram::fake();

    $withPhoto = new InputPollOption();
    $withPhoto->text = 'yes';
    $withPhoto->media = InputMediaPhoto::make(
        media: InputFile::make(fopen('php://temp', 'rb'), 'yes.jpg'),
    );

    $withFileId = new InputPollOption();
    $withFileId->text = 'no';
    $withFileId->media = InputMediaPhoto::make(media: 'file_id');

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)
            ->toHaveKeys(['chat_id', 'question', 'options', 'yes.jpg'])
            ->and($data['yes.jpg'])->toBeInstanceOf(StreamInterface::class)
            ->and($data['options'])->toContain('attach:\/\/yes.jpg', 'file_id');
    });

    $bot->sendPoll(
        question: 'pick one',
        options: [$withPhoto, $withFileId],
        chat_id: 123,
    );
});

it('uploads the media of the poll description and of the quiz explanation', function () {
    $bot = Nutgram::fake();

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $data = array_column($request['multipart'], 'contents', 'name');

        expect($data)->toHaveKeys(['chat_id', 'question', 'options', 'media', 'explanation_media', 'description.mp4', 'thumb.jpg', 'explanation.jpg']);
    });

    $bot->sendPoll(
        question: 'pick one',
        options: ['yes', 'no'],
        chat_id: 123,
        media: InputMediaVideo::make(
            media: InputFile::make(fopen('php://temp', 'rb'), 'description.mp4'),
            thumbnail: InputFile::make(fopen('php://temp', 'rb'), 'thumb.jpg'),
        ),
        explanation_media: InputMediaPhoto::make(
            media: InputFile::make(fopen('php://temp', 'rb'), 'explanation.jpg'),
        ),
    );
});

it('sends a poll as multipart with serialized options when there is nothing to upload', function () {
    $bot = Nutgram::fake();

    $option = new InputPollOption();
    $option->text = 'yes';
    $option->media = InputMediaPhoto::make(media: 'file_id');

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request)
            ->toHaveKey('multipart')
            ->not->toHaveKey('json');

        $data = array_column($request['multipart'], 'contents', 'name');
        expect($data)->toHaveCount(3)->toHaveKeys(['chat_id', 'question', 'options'])
            ->and($data['options'])->toBeString()
            ->toContain('"media":{"type":"photo","media":"file_id"}');
    });

    $bot->sendPoll(question: 'pick one', options: [$option], chat_id: 123);
});
