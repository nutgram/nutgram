<?php

use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
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

    $cache = mock(ArrayCache::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('getNow')
        ->andReturn(new DateTimeImmutable('2023-12-25 00:00:00'))
        ->getMock();
    $bot->setCache($cache);

    $bot->setGlobalData('test', 'foo', 1);

    $cache = mock(ArrayCache::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('getNow')
        ->andReturn(new DateTimeImmutable('2023-12-25 00:00:02'))
        ->getMock();
    $bot->setCache($cache);

    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('bar');
});
