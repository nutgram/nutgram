<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\MultiTypeConversation;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\MultiTypeConversationNoFallback;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\MultiTypeMultiClosure;

it('uses next with condition', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', MultiTypeConversation::class);

    $bot
        ->willStartConversation()
        ->hearText('/start')
        ->reply()
        ->assertActiveConversation();

    expect($bot->get('test'))->toBe('start');

    $bot
        ->hearText('a text message')
        ->reply()
        ->assertNoConversation();

    expect($bot->get('test'))->toBe('text');
});

it('uses next with multiclosure', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', MultiTypeMultiClosure::class);

    $bot
        ->willStartConversation()
        ->hearText('/start')
        ->reply()
        ->assertReplyText('start!')
        ->assertActiveConversation()
        ->hearText('foo')
        ->reply()
        ->assertReplyText('foo!')
        ->assertNoConversation();

    $bot
        ->willStartConversation()
        ->hearText('/start')
        ->reply()
        ->assertReplyText('start!')
        ->assertActiveConversation()
        ->hearText('bar')
        ->reply()
        ->assertReplyText('bar!');
});

it('uses next with condition with invalid update', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', MultiTypeConversation::class);

    $bot
        ->willStartConversation()
        ->hearText('/start')
        ->reply()
        ->assertActiveConversation();

    expect($bot->get('test'))->toBe('start');

    $bot
        ->hearMessage([
            'sticker' => [
                'file_id' => 'sticker_file_id',
                'file_unique_id' => 'sticker_file_unique_id',
                'width' => 512,
                'height' => 512,
            ],
        ])
        ->reply()
        ->assertReplyText('Invalid message type.')
        ->assertActiveConversation();

    expect($bot->get('test'))->toBe('start');
});

it('uses next with condition with invalid update + no fallback', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', MultiTypeConversationNoFallback::class);

    $bot
        ->willStartConversation()
        ->hearText('/start')
        ->reply()
        ->assertReplyText('Waiting for a callback query...')
        ->assertActiveConversation();

    expect($bot->get('test'))->toBe('start');

    $bot
        ->hearText('hello')
        ->reply()
        ->assertReplyText('Waiting for a callback query...')
        ->assertActiveConversation();

    expect($bot->get('test'))->toBe('start');
});
