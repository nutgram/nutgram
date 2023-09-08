<?php

use function SergiX44\Nutgram\Support\word_wrap;

it('chunks text', function (int $byteLimit, string $text, array $expected) {
    $actual = explode('%#TGMSG#%', word_wrap($text, $byteLimit, "%#TGMSG#%", true));
    expect($actual)->toBe($expected);
})->with([
    'normal' => [10, 'abcdefghijklmno', ['abcdefghij', 'klmno']],
    'accent' => [10, 'áéíóúáéíóúáéí', ['áéíóúáéíóú', 'áéí']],
    'cyrillic' => [10, 'абвгдеёжзиабвгд', ['абвгдеёжзи', 'абвгд']],
    'emoji' => [
        10,
        '🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️🧜🏻‍♂️',
        ['🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️🧜🏻‍♂️', '🧜🏻‍♂️']
    ],
]);
