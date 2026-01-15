<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Testing\FakeNutgram;
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

it('checks two middleware in chain', function () {
    Nutgram::fake()
        ->setCommonUser(User::make(1111, false, 'John'))
        ->hearText('test')
        ->willTestMiddleware(IsAdmin::class)
        ->willTestMiddleware(new HasPermission('test'))
        ->reply()
        ->assertMiddlewarePassed()
        ->assertMiddlewarePassed(1);
});

it('checks two middleware in chain using sequence', function () {
    Nutgram::fake()
        ->setCommonUser(User::make(1111, false, 'John'))
        ->hearText('test')
        ->willTestMiddleware(IsAdmin::class)
        ->willTestMiddleware(new HasPermission('test'))
        ->reply()
        ->assertSequence(
            fn(FakeNutgram $x) => $x->assertMiddlewarePassed(),
            fn(FakeNutgram $x) => $x->assertMiddlewarePassed(),
        );
});
