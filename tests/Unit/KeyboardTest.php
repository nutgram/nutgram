<?php

use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

it('makes a correct InlineKeyboardMarkup', function () {
    $expected = [
        'inline_keyboard' => [
            [
                ['text' => 'test', 'callback_data' => 'test2'],
                ['text' => 'test3', 'callback_data' => 'test4'],
            ],
        ],
    ];

    $keyboard = InlineKeyboardMarkup::make()
        ->addRow(
            InlineKeyboardButton::make('test', callback_data: 'test2'),
            InlineKeyboardButton::make('test3', callback_data: 'test4')
        );


    expect(json_encode($keyboard))->toBe(json_encode($expected));
});

it('makes a correct ReplyKeyboardMarkup', function () {
    $expected = [
        'keyboard' => [
            [
                ['text' => 'test'],
            ],
            [
                [
                    'text' => 'send contact',
                    'request_contact' => true,
                ],
            ],
        ],
        'is_persistent' => true,
        'resize_keyboard' => true,
        'one_time_keyboard' => true,
        'input_field_placeholder' => 'test',
        'selective' => true,
    ];

    $keyboard = ReplyKeyboardMarkup::make(
        resize_keyboard: true,
        one_time_keyboard: true,
        input_field_placeholder: 'test',
        selective: true,
        is_persistent: true,
    )
        ->addRow(
            KeyboardButton::make('test'),
        )
        ->addRow(
            KeyboardButton::make('send contact', request_contact: true),
        );

    expect(json_encode($keyboard))->toBe(json_encode($expected));
});

it('makes a correct ForceReply', function () {
    $expected = [
        'force_reply' => true,
        'input_field_placeholder' => 'test',
        'selective' => true,
    ];

    $keyboard = ForceReply::make(
        force_reply: true,
        input_field_placeholder: 'test',
        selective: true
    );

    expect(json_encode($keyboard))->toBe(json_encode($expected));
});
