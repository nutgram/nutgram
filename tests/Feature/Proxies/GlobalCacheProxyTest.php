<?php

use SergiX44\Nutgram\Nutgram;

test('getGlobalData() returns default value', function () {
    $bot = Nutgram::fake();

    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('bar');
});

test('getGlobalData() returns value after calling setGlobalData()', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo');
    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('foo');
});

test('getGlobalData() returns default value if key missing', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo');
    $value = $bot->getGlobalData('tests', 'bar');

    expect($value)->toBe('bar');
});

test('deleteGlobalData() remove stored value', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo');
    $bot->deleteGlobalData('test');
    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('bar');
});

test('getGlobalData() returns value after calling setGlobalData() with valid TTL', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo', 1);
    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('foo');
});

test('getGlobalData() returns default value after calling setGlobalData() with expired TTL', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo', 1);
    sleep(2);
    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('bar');
});
