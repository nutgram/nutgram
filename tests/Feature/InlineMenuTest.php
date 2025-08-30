<?php

declare(strict_types=1);

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\MissingMethodMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidButtonNoCallbackMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidButtonNoDataMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidNoEndMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidReopenMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidSameDataMenu;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\InlineMenu\ValidWithFallbackMenu;

test('valid inline menu + no end', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidNoEndMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertActiveConversation()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'red'))
                ->addRow(new InlineKeyboardButton('Green', callback_data: 'green'))
                ->addRow(new InlineKeyboardButton('Yellow', callback_data: 'yellow'))
        ])
        ->hearCallbackQueryData('red')
        ->reply()
        ->assertReplyText('Choosen: red!')
        ->assertReply('answerCallbackQuery', [
            'show_alert' => true,
            'text' => 'Alert!',
        ], 1)
        ->hearText('start')
        ->reply()
        ->assertNoConversation();
});

test('valid inline menu + no end + no data', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidButtonNoDataMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'Red'))
        ])
        ->hearCallbackQueryData('Red')
        ->reply()
        ->assertReplyText('Choosen: Red!')
        ->assertReply('answerCallbackQuery', index: 1);
});

test('valid inline menu + no end + no callback data', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidButtonNoCallbackMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyText('Choose a color:');
});

test('valid inline menu + reopen', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidReopenMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'red'))
                ->addRow(new InlineKeyboardButton('Green', callback_data: 'green'))
                ->addRow(new InlineKeyboardButton('Yellow', callback_data: 'yellow'))
        ])
        ->hearCallbackQueryData('red')
        ->reply()
        ->assertCalled('deleteMessage')
        ->assertReplyText('Choosen: red!', index: 1)
        ->assertReply('answerCallbackQuery', index: 2);
});

test('valid inline menu + orNext + click button', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidWithFallbackMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'red'))
                ->addRow(new InlineKeyboardButton('Green', callback_data: 'green'))
                ->addRow(new InlineKeyboardButton('Yellow', callback_data: 'yellow'))
        ])
        ->hearCallbackQueryData('red')
        ->reply()
        ->assertReplyText('Choosen: red!')
        ->assertReplyText('Bye!', 1);
});

test('valid inline menu + orNext + no button click', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidWithFallbackMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'red'))
                ->addRow(new InlineKeyboardButton('Green', callback_data: 'green'))
                ->addRow(new InlineKeyboardButton('Yellow', callback_data: 'yellow'))
        ])
        ->hearText('wow')
        ->reply()
        ->assertReplyText('Bye!');
});

test('missing callback method', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(MissingMethodMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply();
})->throws(InvalidArgumentException::class, 'The method handleMissing does not exists.');

test('invalid assertActiveConversation without calling willStartConversation method', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidNoEndMenu::class);

    $bot
        ->hearText('start')
        ->reply()
        ->assertActiveConversation();
})->throws(InvalidArgumentException::class, 'You cannot do this assert without userId and chatId.');

test('invalid assertNoConversation without calling willStartConversation method', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidNoEndMenu::class);

    $bot
        ->hearText('start')
        ->reply()
        ->assertNoConversation();
})->throws(InvalidArgumentException::class, 'You cannot do this assert without userId and chatId.');

test('works with same callback data but different callback method', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidSameDataMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertActiveConversation()
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => new InlineKeyboardMarkup()
                ->addRow(new InlineKeyboardButton('Red', callback_data: 'red'))
                ->addRow(new InlineKeyboardButton('Green', callback_data: 'red@'))
                ->addRow(new InlineKeyboardButton('Yellow', callback_data: 'red@@'))
        ])
        ->hearCallbackQueryData('red@')
        ->reply()
        ->assertReplyText('Choosen: 2red!')
        ->assertReply('answerCallbackQuery', [
            'show_alert' => true,
            'text' => 'Alert!',
        ], 1)
        ->hearText('start')
        ->reply()
        ->assertNoConversation()
        ->hearText('start')
        ->reply()
        ->assertActiveConversation()
        ->hearCallbackQueryData('red@@')
        ->reply()
        ->assertReplyText('Choosen: 3red!')
        ->assertReply('answerCallbackQuery', [
            'show_alert' => true,
            'text' => 'Alert!',
        ], 1)
        ->hearText('start')
        ->reply()
        ->assertNoConversation()
        ->hearText('start')
        ->reply()
        ->assertActiveConversation()
        ->hearCallbackQueryData('red')
        ->reply()
        ->assertReplyText('Choosen: 1red!')
        ->assertReply('answerCallbackQuery', [
            'show_alert' => true,
            'text' => 'Alert!',
        ], 1);
});

it('starts an inline menu from server', function () {
    $bot = Nutgram::fake();

    ValidWithFallbackMenu::begin(
        bot: $bot,
        userId: 123456789,
        chatId: 123456789
    );

    $bot->assertReply('sendMessage', [
        'text' => 'Choose a color:',
        'chat_id' => 123456789
    ]);
});
