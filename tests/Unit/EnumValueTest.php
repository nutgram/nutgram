<?php

use function SergiX44\Nutgram\Support\enum_value;

it('returns a string from a string', function () {
    $value = 'test';

    $result = enum_value($value);

    expect($result)->toBe($value);
});

it('returns a string from an enum', function () {
    enum TestEnum: string
    {
        case TEST = 'test';
    }

    $result = enum_value(TestEnum::TEST);

    expect($result)->toBe(TestEnum::TEST->value);
});
