<?php

use SergiX44\Nutgram\Nutgram;

it('runs the bulk messenger', function () {
    $bot = Nutgram::fake();

    $bot->getBulkMessenger()
        ->setInterval(0)
        ->setChats([1, 2, 3])
        ->setText('*AAA*')
        ->setOpt(['parse_mode' => \SergiX44\Nutgram\Telegram\Attributes\ParseMode::MARKDOWN])
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
