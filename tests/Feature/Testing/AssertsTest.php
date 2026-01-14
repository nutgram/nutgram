<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Tests\Fixtures\Middleware\HasPermission;
use SergiX44\Nutgram\Tests\Fixtures\Middleware\IsAdmin;

test('assertMiddlewarePassed pass', function (int $user, string $text, mixed $middleware) {
    Nutgram::fake()
        ->setCommonUser(User::make($user, false, 'John'))
        ->hearText($text)
        ->reply()
        ->assertMiddlewarePassed($middleware);
})->with([
    'no constructor' => [1111, 'hello', IsAdmin::class],
    'with constructor' => [1111, 'test', new HasPermission('test')],
]);

test('assertMiddlewareBlocked pass with constructor', function (int $user, string $text, mixed $middleware) {
    Nutgram::fake()
        ->setCommonUser(User::make($user, false, 'John'))
        ->hearText($text)
        ->reply()
        ->assertMiddlewareBlocked($middleware);
})->with([
    'no constructor' => [9999, 'hello', IsAdmin::class],
    'with constructor' => [1111, 'foo', new HasPermission('test')],
]);
