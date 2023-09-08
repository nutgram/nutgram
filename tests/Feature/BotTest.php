<?php

use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Testing\FakeNutgram;
use SergiX44\Nutgram\Testing\FormDataParser;
use SergiX44\Nutgram\Testing\OutgoingResource;
use SergiX44\Nutgram\Tests\Fixtures\CustomLogger;
use SergiX44\Nutgram\Tests\Fixtures\MyService;
use SergiX44\Nutgram\Tests\Fixtures\ServiceHandler;

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

            return is_resource($document->getTmpResource());
        });
});

it('throws an exception when no fake update specified', function () {
    $bot = Nutgram::fake();
    $bot->reply();
})->expectException(InvalidArgumentException::class);

it('uses a different container', function () {
    $differentContainer = new Container();
    $differentContainer->singleton(MyService::class, fn () => new MyService('hello'));

    $bot = Nutgram::fake(config: new Configuration(
        container: $differentContainer
    ));

    $bot->onCommand('test', ServiceHandler::class);

    $bot->hearText('/test')
        ->reply()
        ->assertReplyText('hello');
});

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
