<?php

use SergiX44\Nutgram\Nutgram;

test('getData() returns default value', function () {
    $bot = Nutgram::fake();

    $value = $bot->getData('test', 'bar');

    expect($value)->toBe('bar');
});

test('getData() returns value after calling setData()', function () {
    $bot = Nutgram::fake();

    $bot->setData('test', 'foo');
    $value = $bot->getData('test', 'bar');

    expect($value)->toBe('foo');
});

test('deleteData() remove stored value', function () {
    $bot = Nutgram::fake();

    $bot->setData('test', 'foo');
    $bot->deleteData('test');
    $value = $bot->getData('test', 'bar');

    expect($value)->toBe('bar');
});

test('clearData() remove all stored values', function () {
    $bot = Nutgram::fake();

    $bot->setData('test', 'foo');
    $bot->setData('test2', 'foo2');
    $bot->clearData();

    expect($bot->getData('test', 'bar'))->toBe('bar');
    expect($bot->getData('test2', 'bar2'))->toBe('bar2');
});
