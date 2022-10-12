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

test('deleteGlobalData() remove stored value', function () {
    $bot = Nutgram::fake();

    $bot->setGlobalData('test', 'foo');
    $bot->deleteGlobalData('test');
    $value = $bot->getGlobalData('test', 'bar');

    expect($value)->toBe('bar');
});
