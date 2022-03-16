<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;

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
