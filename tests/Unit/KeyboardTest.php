<?php

use SergiX44\Nutgram\Telegram\Types\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\InlineKeyboardMarkup;

it('make a correct keyboard', function () {

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