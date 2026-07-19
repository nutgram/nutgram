<?php

use PHPUnit\Framework\AssertionFailedError;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaDocument;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Testing\FakeNutgram;
use SergiX44\Nutgram\Testing\RequestData;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithDefault;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ServerConversation;

test('assertRaw without history', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->assertRaw(function (RequestData $request) {
        return $request->get('text') === 'test';
    });
})->throws(AssertionFailedError::class);

test('assertRaw without files', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->hearText('/test')
        ->reply()
        ->assertRaw(function (RequestData $request) {
            return $request->get('text') === 'test';
        });
});

test('assertRaw with file', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendDocument(
            document: InputFile::makeFromString('Hello world!'),
            caption: 'test',
            reply_to_message_id: 123,
            allow_sending_without_reply: true,
            reply_markup: new InlineKeyboardMarkup()
                ->addRow(
                    new InlineKeyboardButton(text: 'foo', url: 'https://example.foo/'),
                    new InlineKeyboardButton(text: 'bar', url: 'https://example.bar/'),
                )
        );
    });

    $bot->hearText('/test')
        ->reply()
        ->assertRaw(function (RequestData $request) {
            return $request->get('caption') === 'test'
                && $request->file('document')->getStream()->getContents() === 'Hello world!';
        });
});

test('assertRaw with multiple files', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMediaGroup(
            media: [
                new InputMediaDocument(
                    media: InputFile::makeFromString('foo', 'foo.txt'),
                    caption: 'foo',
                ),
                new InputMediaDocument(
                    media: InputFile::makeFromString('bar', 'bar.txt'),
                    caption: 'bar',
                ),
            ]
        );
    });

    $bot->hearText('/test')
        ->reply()
        ->assertRaw(function (RequestData $request) {
            return $request->file('foo.txt')->getStream()->getContents() === 'foo'
                && $request->file('bar.txt')->getStream()->getContents() === 'bar';
        });
});

test('assertCalled 0 times', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertCalled('sendDocument', 0);
});

test('assertCalled 1 times', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertCalled('sendMessage');
});

test('assertCalled 2 times', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
        $bot->sendMessage('test');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertCalled('sendMessage', 2);
});

test('assertReply without history', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage(
            text: 'test',
            disable_notification: true,
        );
    });

    $bot->assertReply('sendMessage', [
        'text' => 'test',
        'disable_notification' => true,
    ]);
})->throws(AssertionFailedError::class);

test('assertReply executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage(
            text: 'test',
            disable_notification: true,
        );
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertReply('sendMessage', [
            'text' => 'test',
            'disable_notification' => true,
        ]);
});

test('assertReplyMessage executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage(
            text: 'test',
            disable_notification: true,
        );
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertReplyMessage([
            'text' => 'test',
            'disable_notification' => true,
        ]);
});

test('assertReplyText executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertReplyText('test');
});

test('assertActiveConversation executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', ServerConversation::class);

    $bot
        ->willStartConversation()
        ->hearText('/test')
        ->reply()
        ->assertActiveConversation();
});

test('assertActiveConversation fail without willStartConversation', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', ServerConversation::class);

    $bot
        ->hearText('/test')
        ->reply()
        ->assertActiveConversation();
})->throws(InvalidArgumentException::class, 'You cannot do this assert without userId and chatId.');

test('assertNoConversation executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', ConversationWithDefault::class);

    $bot
        ->willStartConversation()
        ->hearText('/test')
        ->reply()
        ->assertNoConversation();
});

test('assertNoConversation fail without willStartConversation', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', ConversationWithDefault::class);

    $bot
        ->hearText('/test')
        ->reply()
        ->assertNoConversation();
})->throws(InvalidArgumentException::class, 'You cannot do this assert without userId and chatId.');

test('assertNoReply executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        // :/
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertNoReply();
});

test('assertSequence executed', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->sendMessage('test 1');
        $bot->sendMessage('test 2');
    });

    $bot
        ->hearText('/test')
        ->reply()
        ->assertSequence(
            fn (FakeNutgram $x) => $x->assertReplyText('test 1'),
            fn (FakeNutgram $x) => $x->assertReplyText('test 2')
        );
});
