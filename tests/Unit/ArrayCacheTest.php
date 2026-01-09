<?php

declare(strict_types=1);

use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
use SergiX44\Nutgram\Testing\TestClock;

beforeEach(function () {
    $this->cache = new ArrayCache(new TestClock());
});

it('gets value', function () {
    $this->cache->set('foo', 'bar');
    expect($this->cache->get('foo'))->toBe('bar');
});

it('does not get value due to missing key', function () {
    expect($this->cache->get('foo', 'baz'))->toBe('baz');
});

it('does not get value due to expired key', function ($ttl) {
    TestClock::freeze();

    $this->cache->set('foo', 'bar', $ttl);

    TestClock::sleep(2);

    expect($this->cache->get('foo', 'baz'))->toBe('baz');
})->with([
    'int' => [1],
    'DateInterval' => [new DateInterval('PT1S')],
]);

it('deletes key', function () {
    $this->cache->set('foo', 'bar');
    $this->cache->delete('foo');
    expect($this->cache->get('foo', 'baz'))->toBe('baz');
});

it('clears keys', function () {
    $this->cache->set('foo', 'bar');
    $this->cache->clear();
    expect($this->cache->get('foo', 'baz'))->toBe('baz');
});

it('gets multiple values', function () {
    $this->cache->setMultiple(['foo' => 'bar', 'super' => 'mario']);
    expect($this->cache->getMultiple(['foo', 'super']))->toBe(['foo' => 'bar', 'super' => 'mario']);
});

it('deletes multiple values', function () {
    $this->cache->setMultiple(['foo' => 'bar', 'super' => 'mario']);
    $this->cache->deleteMultiple(['foo', 'super']);
    expect($this->cache->getMultiple(['foo', 'super']))->toBe(['foo' => null, 'super' => null]);
});

test('has returns true if key exists', function () {
    $this->cache->set('foo', 'bar');
    expect($this->cache->has('foo'))->toBeTrue();
});

test('has returns false if key does not exist', function () {
    expect($this->cache->has('foo'))->toBeFalse();
});
