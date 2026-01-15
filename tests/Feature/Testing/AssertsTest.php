<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Tests\Fixtures\Middleware\HasPermission;
use SergiX44\Nutgram\Tests\Fixtures\Middleware\IsAdmin;

it('asserts the middleware passes', function (int $user, string $text, mixed $middleware) {
    Nutgram::fake()
        ->setCommonUser(User::make($user, false, 'John'))
        ->hearText($text)
        ->willTestMiddleware($middleware)
        ->reply()
        ->assertMiddlewarePassed();
})->with([
    'string' => [1111, 'hello', IsAdmin::class],
    'instance' => [1111, 'test', new HasPermission('test')],
    'array' => [2222, 'test', [IsAdmin::class, 'moderator']],
]);

it('asserts the middleware fails', function (int $user, string $text, mixed $middleware, string $message) {
    Nutgram::fake()
        ->setCommonUser(User::make($user, false, 'John'))
        ->hearText($text)
        ->willTestMiddleware($middleware)
        ->reply()
        ->assertReplyText($message)
        ->assertMiddlewareBlocked();
})->with([
    'string' => [9999, 'hello', IsAdmin::class, 'You are not admin'],
    'instance' => [1111, 'foo', new HasPermission('test'), 'You have no permission'],
    'array' => [0000, 'test', [IsAdmin::class, 'moderator'], 'You are not moderator'],
]);

it('checks two middleware at once', function () {
    Nutgram::fake()
        ->setCommonUser(User::make(6666, false, 'John'))
        ->hearText('foo')
        ->willTestMiddleware(IsAdmin::class)
        ->willTestMiddleware([IsAdmin::class, 'moderator'])
        ->reply()
        ->assertMiddlewareBlocked()
        ->assertMiddlewareBlocked(1);
});
