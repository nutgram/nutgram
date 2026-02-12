<?php

declare(strict_types=1);

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

    $keyboard = new InlineKeyboardMarkup()
        ->addRow(
            new InlineKeyboardButton('test', callback_data: 'test2'),
            new InlineKeyboardButton('test3', callback_data: 'test4')
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

    $keyboard = new ReplyKeyboardMarkup(
        resize_keyboard: true,
        one_time_keyboard: true,
        input_field_placeholder: 'test',
        selective: true,
        is_persistent: true,
    )
        ->addRow(
            new KeyboardButton('test'),
        )
        ->addRow(
            new KeyboardButton('send contact', request_contact: true),
        );

    expect(json_encode($keyboard))->toBe(json_encode($expected));
});

it('makes a correct ForceReply', function () {
    $expected = [
        'force_reply' => true,
        'input_field_placeholder' => 'test',
        'selective' => true,
    ];

    $keyboard = new ForceReply(
        force_reply: true,
        input_field_placeholder: 'test',
        selective: true
    );

    expect(json_encode($keyboard))->toBe(json_encode($expected));
});
