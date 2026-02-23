<?php

use SergiX44\Nutgram\Tests\Fixtures\TestEnum;
use function SergiX44\Nutgram\Support\enum_value;

it('returns a string from a string', function () {
    $value = 'test';

    $result = enum_value($value);

    expect($result)->toBe($value);
});

it('returns a string from an enum', function () {
    $result = enum_value(TestEnum::Test);

    expect($result)->toBe(TestEnum::Test->value);
});
