<?php

use function SergiX44\Nutgram\Support\word_wrap;

test('validate word_wrap logic', function (string $input, string $expected) {
    $actual = explode('§', word_wrap(
        string: $input,
        width: 3,
        break: '§',
        cut: true
    ));

    $actual = json_encode($actual, JSON_UNESCAPED_UNICODE);

    expect($actual)->toBe($expected);
})->with([
    ['Hello', '["Hel","lo"]'],
    ['пример', '["при","мер"]'],
    ['hàçòùéì', '["hàç","òùé","ì"]'],
    ['He🧜‍♀️llo', '["He🧜‍♀️","llo"]'],
    ['Hello💁🏽', '["Hel","lo💁🏽"]'],
    ['💁🏽🧜‍♀️💁🏽🧜‍♀️💁🏽🧜‍♀️', '["💁🏽🧜‍♀️💁🏽","🧜‍♀️💁🏽🧜‍♀️"]'],
    ['Allahümme', '["All","ahü","mme"]'],
]);
