<?php

use function SergiX44\Nutgram\Support\word_wrap;

test('validate word_wrap logic', function (int $width, string $text, array $expected) {
    $actual = explode('§', word_wrap(string: $text, width: $width, break: '§', cut: true));
    expect($actual)->toBe($expected);
})->with([
    [3, 'Hello', ["Hel", "lo"]],
    [3, 'пример', ["при", "мер"]],
    [3, 'hàçòùéì', ["hàç", "òùé", "ì"]],
    [3, 'Allahümme', ["All", "ahü", "mme"]],
    [10, 'abcdefghijklmno', ['abcdefghij', 'klmno']],
    [10, 'áéíóúáéíóúáéí', ['áéíóúáéíóú', 'áéí']],
    [10, 'абвгдеёжзиабвгд', ['абвгдеёжзи', 'абвгд']],
    [
        10,
        '🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️',
        ['🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️']
    ],

    //TODO: fix cut emoji
    //[3, 'He🧜‍♀️llo', ["He🧜‍♀️","llo"]],
    //[3, 'Hello💁🏽', ["Hel","lo💁🏽"]],
    //[3, '💁🏽🧜‍♀️💁🏽🧜‍♀️💁🏽🧜‍♀️', ["💁🏽🧜‍♀️💁🏽","🧜‍♀️💁🏽🧜‍♀️"]],
]);
