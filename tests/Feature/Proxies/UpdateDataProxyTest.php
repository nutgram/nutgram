<?php

use SergiX44\Nutgram\Nutgram;

test('get() returns default value', function () {
    $bot = Nutgram::fake();

    $value = $bot->get('test', 'bar');

    expect($value)->toBe('bar');
});

test('get() returns value after calling set()', function () {
    $bot = Nutgram::fake();

    $bot->set('test', 'foo');
    $value = $bot->get('test', 'bar');

    expect($value)->toBe('foo');
});

test('delete() remove stored value', function () {
    $bot = Nutgram::fake();

    $bot->set('test', 'foo');
    $bot->delete('test');
    $value = $bot->get('test', 'bar');

    expect($value)->toBe('bar');
});

test('clear() remove all stored values', function () {
    $bot = Nutgram::fake();

    $bot->set('test', 'foo');
    $bot->set('test2', 'foo2');
    $bot->clear();

    expect($bot->get('test', 'bar'))->toBe('bar');
    expect($bot->get('test2', 'bar2'))->toBe('bar2');
});
