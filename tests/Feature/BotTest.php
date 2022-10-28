<?php

use GuzzleHttp\Psr7\Request;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Testing\FormDataParser;
use SergiX44\Nutgram\Testing\OutgoingResource;

it('throws exception if the token is empty', function () {
    new Nutgram('');
})->throws(InvalidArgumentException::class, 'The token cannot be empty.');

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = Nutgram::fake($update);

    expect($bot->getUpdateMode())->toBe(Fake::class);
})->with('callback_query');

it('works as mocked instance', function () {
    $bot = Nutgram::fake()
        ->hearUpdateType(UpdateTypes::MESSAGE, ['text' => '/testing', 'from' => ['username' => 'XD']])
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
        ->hearUpdateType(UpdateTypes::MESSAGE, ['text' => '/not_test']);

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
            'message_id' => 321
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
            'message_id' => $messageId
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
                'from_chat_id' => $fromChatId
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
            'message_id' => $messageId
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
                'from_chat_id' => $fromChatId
            ],
            index: 1
        );
});

it('sends file works as mocked instance', function () {
    $file = fopen('php://temp', 'rb');

    $bot = Nutgram::fake()
        ->hearText('/test');

    $bot->onCommand('test', function (Nutgram $bot) use ($file) {
        $bot->sendDocument(InputFile::make($file), [
            'caption' => 'test',
            'reply_to_message_id' => 123,
            'allow_sending_without_reply' => true,
        ]);
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
