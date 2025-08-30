<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Testing\FakeNutgram;
use SergiX44\Nutgram\Testing\FormDataParser;
use SergiX44\Nutgram\Testing\OutgoingResource;
use SergiX44\Nutgram\Tests\Fixtures\CustomLogger;

it('throws exception if the token is empty', function () {
    new Nutgram('');
})->throws(InvalidArgumentException::class, 'The token cannot be empty.');

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getRunningMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearUpdateType(UpdateType::MESSAGE, ['text' => '/testing', 'from' => ['username' => 'XD']])
        ->willReceivePartial(['text' => 'aaa'])
        ->willReceivePartial(['chat' => ['id' => 123]]);

    $bot->onCommand('testing', function (Nutgram $bot) {
        $message = $bot->sendMessage('test');

        expect($bot->user()->username)->toBe('XD');

        expect($message->text)->toBe('aaa');

        $message = $bot->sendMessage('sos');

        expect($message->chat->id)->toBe(123);
    });

    $bot->reply()
        ->assertCalled('sendMessage', 2)
        ->assertReply('sendMessage', ['text' => 'test'])
        ->assertReply('sendMessage', ['text' => 'sos'], 1);
});

it('reply text works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearText('/test');

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->reply()
        ->assertReplyText('test');
});

it('no reply works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearUpdateType(UpdateType::MESSAGE, ['text' => '/not_test']);

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->reply()
        ->assertNoReply();
});

it('delete message works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearText('/test')
        ->willReceivePartial([
            'chat' => ['id' => 123],
            'message_id' => 321,
        ]);

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test')?->delete();
    });

    $bot->reply()
        ->assertReplyText('test')
        ->assertReply('deleteMessage', index: 1);
});

it('copy message works as mocked instance', function () {
    $chatId = 1111111;
    $fromChatId = 123;
    $messageId = 321;

    $bot = Nutgram::fake()
        ->hearText('/test')
        ->willReceivePartial([
            'chat' => ['id' => $fromChatId],
            'message_id' => $messageId,
        ]);

    $bot->onCommand('test', function (Nutgram $bot) use ($chatId) {
        $bot->sendMessage('test')?->copy($chatId);
    });

    $bot->reply()
        ->assertReplyText('test')
        ->assertReply(
            'copyMessage',
            expected: [
                'message_id' => $messageId,
                'chat_id' => $chatId,
                'from_chat_id' => $fromChatId,
            ],
            index: 1
        );
});

it('forward message works as mocked instance', function () {
    $chatId = 1111111;
    $fromChatId = 123;
    $messageId = 321;


    $bot = Nutgram::fake()
        ->hearText('/test')
        ->willReceivePartial([
            'chat' => ['id' => $fromChatId],
            'message_id' => $messageId,
        ]);

    $bot->onCommand('test', function (Nutgram $bot) use ($chatId) {
        $bot->sendMessage('test')?->forward($chatId);
    });

    $bot->reply()
        ->assertReplyText('test')
        ->assertReply(
            'forwardMessage',
            expected: [
                'message_id' => $messageId,
                'chat_id' => $chatId,
                'from_chat_id' => $fromChatId,
            ],
            index: 1
        );
});

it('sends file works as mocked instance', function () {
    $file = fopen('php://temp', 'rb');

    $bot = Nutgram::fake()
        ->hearText('/test');

    $bot->onCommand('test', function (Nutgram $bot) use ($file) {
        $bot->sendDocument(
            document: InputFile::make($file),
            caption: 'test',
            reply_to_message_id: 123,
            allow_sending_without_reply: true,
        );
    });

    $bot->reply()
        ->assertReply('sendDocument', [
            'caption' => 'test',
            'reply_to_message_id' => 123,
            'allow_sending_without_reply' => true,
        ])
        ->assertRaw(function (Request $request) {
            /** @var OutgoingResource $document */
            $document = FormDataParser::parse($request)->files['document'];

            return $document->getStream() instanceof StreamInterface;
        });
});

it('throws an exception when no fake update specified', function () {
    $bot = Nutgram::fake();
    $bot->reply();
})->throws(InvalidArgumentException::class);

it('use another logger', function () {
    $bot = Nutgram::fake(config: new Configuration(
        logger: new CustomLogger(),
    ));

    $a = serialize($bot);

    /** @var Nutgram $instance */
    $instance = unserialize($a);

    expect($instance)
        ->toBeInstanceOf(Nutgram::class)
        ->and($instance->getContainer()->get(LoggerInterface::class))
        ->toBeInstanceOf(Configuration::DEFAULT_LOGGER);
});

it('asserts with sequence method', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('foo');
        $bot->sendMessage('bar');
        $bot->sendMessage('baz');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertSequence(
            fn (FakeNutgram $x) => $x->assertReplyText('foo'),
            fn (FakeNutgram $x) => $x->assertReplyText('bar'),
            fn (FakeNutgram $x) => $x->assertReplyText('baz'),
        );
});

it('unescape unicode before sending payload', function (string $text) {
    $bot = Nutgram::fake();
    $bot->sendMessage($text);

    $bot->assertRaw(function (Request $request) use ($text) {
        $content = (string)$request->getBody();
        return $content === sprintf('{"text":"%s"}', $text);
    });
})->with([
    'Hello',
    'пример',
    'hàçòùéì',
    'He🧜‍♀️llo',
    'Hello💁🏽',
    '💁🏽🧜‍♀️💁🏽🧜‍♀️💁🏽🧜‍♀️',
    'Allahümme',
]);

it('returns an array using toArray method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCommand('test', function (Nutgram $bot) {
        $data = $bot->message()?->toArray();

        expect($data)
            ->toBeArray()
            ->text->toBe('/test')
            ->and($data['chat']['type'])->toBe('private');
    });

    $bot->run();
})->with('command');

it('returns a custom download url when using a custom bot api server', function () {
    $bot = Nutgram::fake(config: new Configuration(
        apiUrl: 'https://api.example.com/',
        isLocal: false,
    ));

    $bot->onDocument(function (Nutgram $bot) {
        $document = $bot->message()->document;
        $file = $bot->getFile($document->file_id);
        $url = $bot->downloadUrl($file);

        // domain is ignored because it's overriden by FakeNutgram (test environment only)
        expect($url)->toBe(sprintf(
            '/file/bot%s/%s',
            FakeNutgram::TOKEN,
            'var/lib/telegram-bot-api/1234/photos/file_1.jpg'
        ));
    });

    $bot
        ->hearMessage([
            'document' => [
                'file_id' => '123',
            ],
        ])
        ->willReceivePartial([
            'file_id' => '123',
            'file_path' => '/var/lib/telegram-bot-api/1234/photos/file_1.jpg',
        ])
        ->reply();
});

it('makes a keyboard from array', function () {
    $keyboard = InlineKeyboardMarkup::fromArray([
        'inline_keyboard' => [
            [
                ['text' => 'Button 1', 'callback_data' => 'data_1'],
                ['text' => 'Button 2', 'callback_data' => 'data_2'],
            ],
        ],
    ]);
    expect($keyboard)->toBeInstanceOf(InlineKeyboardMarkup::class);
});
