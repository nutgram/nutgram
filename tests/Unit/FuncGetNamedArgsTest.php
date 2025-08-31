<?php

declare(strict_types=1);

use function SergiX44\Nutgram\Support\func_get_named_args;

test('get arguments from class method', function () {
    $class = new class {
        public function send(string $text, ?int $order = null, ?string $info = null): array
        {
            return func_get_named_args(func_get_args());
        }
    };

    expect($class->send('Hello', 5))->toBe(['text' => 'Hello', 'order' => 5, 'info' => null]);
    expect($class->send('Hello'))->toBe(['text' => 'Hello', 'order' => null, 'info' => null]);
    expect($class->send('Hello', info: 'ok'))->toBe(['text' => 'Hello', 'order' => null, 'info' => 'ok']);
});

test('unable to get arguments from closure', function () {
    $closure = function (string $text, ?int $order = null, ?string $info = null) {
        return func_get_named_args(func_get_args());
    };

    expect($closure('Hello', 5))->toBe(['text' => 'Hello', 'order' => 5, 'info' => null]);
})->throws(ReflectionException::class);
