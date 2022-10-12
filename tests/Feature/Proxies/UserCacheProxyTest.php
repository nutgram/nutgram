<?php

use SergiX44\Nutgram\Nutgram;

test('getUserData() returns default value if it does not exist', function () {
    $bot = Nutgram::fake();

    $value = $bot->getUserData(key: 'test', userId: 123, default: 'bar');

    expect($value)->toBe('bar');
});

test('getUserData() returns default value if it does exist but the userId is not equal', function () {
    $bot = Nutgram::fake();

    $bot->setUserData(key: 'test', value: 'foo', userId: 321);
    $value = $bot->getUserData(key: 'test', userId: 123, default: 'bar');

    expect($value)->toBe('bar');
});

test('getUserData() returns value after calling setUserData()', function () {
    $bot = Nutgram::fake();

    $bot->setUserData(key: 'test', value: 'foo', userId: 123);
    $value = $bot->getUserData(key: 'test', userId: 123, default: 'bar');

    expect($value)->toBe('foo');
});

test('deleteUserData() not remove stored value if userId is not equal', function () {
    $bot = Nutgram::fake();

    $bot->setUserData(key: 'test', value: 'foo', userId: 123);
    $bot->deleteUserData(key: 'test', userId: 321);
    $value = $bot->getUserData(key: 'test', userId: 123, default: 'bar');

    expect($value)->toBe('foo');
});

test('deleteUserData() remove stored value', function () {
    $bot = Nutgram::fake();

    $bot->setUserData(key: 'test', value: 'foo', userId: 123);
    $bot->deleteUserData(key: 'test', userId: 123);
    $value = $bot->getUserData(key: 'test', userId: 123, default: 'bar');

    expect($value)->toBe('bar');
});
