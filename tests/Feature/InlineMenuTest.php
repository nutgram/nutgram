<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Tests\Feature\Conversations\InlineMenu\MissingMethodMenu;
use SergiX44\Nutgram\Tests\Feature\Conversations\InlineMenu\ValidNoEndMenu;
use SergiX44\Nutgram\Tests\Feature\Conversations\InlineMenu\ValidWithFallbackMenu;

test('valid inline menu + no end', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidNoEndMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyText('Choose a color:')
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => InlineKeyboardMarkup::make()
                ->addRow(InlineKeyboardButton::make('Red', callback_data: 'red'))
                ->addRow(InlineKeyboardButton::make('Green', callback_data: 'green'))
                ->addRow(InlineKeyboardButton::make('Yellow', callback_data: 'yellow'))
        ])
        ->hearCallbackQueryData('red')
        ->reply()
        ->assertReplyText('Choosen: red!')
        ->assertReply('answerCallbackQuery', [
            'show_alert' => true,
            'text' => 'Alert!',
        ], 1)
        ->hearText('start')
        ->reply();
});

test('valid inline menu + orNext + click button', function () {
    $bot = Nutgram::fake();
    $bot->onMessage(ValidWithFallbackMenu::class);

    $bot
        ->willStartConversation()
        ->hearText('start')
        ->reply()
        ->assertReplyText('Choose a color:')
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => InlineKeyboardMarkup::make()
                ->addRow(InlineKeyboardButton::make('Red', callback_data: 'red'))
                ->addRow(InlineKeyboardButton::make('Green', callback_data: 'green'))
                ->addRow(InlineKeyboardButton::make('Yellow', callback_data: 'yellow'))
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
        ->assertReplyText('Choose a color:')
        ->assertReplyMessage([
            'text' => 'Choose a color:',
            'reply_markup' => InlineKeyboardMarkup::make()
                ->addRow(InlineKeyboardButton::make('Red', callback_data: 'red'))
                ->addRow(InlineKeyboardButton::make('Green', callback_data: 'green'))
                ->addRow(InlineKeyboardButton::make('Yellow', callback_data: 'yellow'))
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
