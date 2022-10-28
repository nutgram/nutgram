<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\BulkMessenger;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

it('does not run when not in cli mode', function () {
    $bot = Nutgram::fake();

    $extendedBulkMessenger = new class($bot) extends BulkMessenger {
        protected function isCli(): bool
        {
            return false;
        }
    };

    $bot = mock($bot)
        ->shouldAllowMockingProtectedMethods()
        ->makePartial()
        ->shouldReceive('getBulkMessenger')
        ->andReturn($extendedBulkMessenger)
        ->getMock();

    $bot->getBulkMessenger();
})->throws(RuntimeException::class, 'You can use the bulk messenger only via CLI.');

it('does not run (async mode) without pcntl support', function () {
    $bot = Nutgram::fake();

    $extendedBulkMessenger = new class($bot) extends BulkMessenger {
        protected function hasPcntl(): bool
        {
            return false;
        }
    };

    $bot = mock($bot)
        ->shouldAllowMockingProtectedMethods()
        ->makePartial()
        ->shouldReceive('getBulkMessenger')
        ->andReturn($extendedBulkMessenger)
        ->getMock();

    $bot->getBulkMessenger()
        ->setInterval(0)
        ->setChats([1, 2, 3])
        ->setText('*AAA*')
        ->setOpt(['parse_mode' => ParseMode::MARKDOWN])
        ->startAsync();
})->throws(RuntimeException::class, 'The pcntl extension is required.');

it('runs the bulk messenger', function () {
    $bot = Nutgram::fake();

    $bot->getBulkMessenger()
        ->setInterval(0)
        ->setChats([1, 2, 3])
        ->setText('*AAA*')
        ->setOpt(['parse_mode' => ParseMode::MARKDOWN])
        ->startSync();

    $bot->assertCalled('sendMessage', 3)
        ->assertReplyText('*AAA*')
        ->assertReplyText('*AAA*', 1)
        ->assertReplyText('*AAA*', 2)
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'])
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'], 1)
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'], 2);
});

it('runs the bulk messenger with using method', function () {
    $bot = Nutgram::fake();

    $bot->getBulkMessenger()
        ->setInterval(0)
        ->setChats([1, 2, 3])
        ->using(function (Nutgram $bot, int $chatId) {
            $bot->sendMessage('*AAA*', [
                'chat_id' => $chatId,
                'parse_mode' => ParseMode::MARKDOWN,
                'protect_content' => true,
            ]);
        })
        ->startSync();

    $bot->assertCalled('sendMessage', 3)
        ->assertReplyText('*AAA*')
        ->assertReplyText('*AAA*', 1)
        ->assertReplyText('*AAA*', 2)
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'])
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'], 1)
        ->assertReplyMessage(['parse_mode' => 'MarkdownV2'], 2);
});

it('bulk messenger skips if no chats are provided', function () {
    $bot = Nutgram::fake();

    $bot->getBulkMessenger()
        ->setInterval(0)
        ->setText('AAA')
        ->startSync();

    $bot->assertNoReply();
});
