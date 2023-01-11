<?php

use SergiX44\Nutgram\Cache\Adapters\ArrayCache;

beforeEach(function () {
    $this->cache = new ArrayCache();
});

it('gets value', function () {
    $this->cache->set('foo', 'bar');
    expect($this->cache->get('foo'))->toBe('bar');
});

it('does not get value due to missing key', function () {
    expect($this->cache->get('foo', 'baz'))->toBe('baz');
});

it('does not get value due to expired key', function () {
    $this->cache = mock(ArrayCache::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('getNow')
        ->andReturn(new DateTimeImmutable('2023-12-25 00:00:00'))
        ->getMock();

    $this->cache->set('foo', 'bar', 1);

    $this->cache = mock(ArrayCache::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('getNow')
        ->andReturn(new DateTimeImmutable('2023-12-25 00:00:02'))
        ->getMock();

    expect($this->cache->get('foo', 'baz'))->toBe('baz');
});

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

test('has returns trye if key exists', function () {
    $this->cache->set('foo', 'bar');
    expect($this->cache->has('foo'))->toBeTrue();
});

test('has returns false if key does not exist', function () {
    expect($this->cache->has('foo'))->toBeFalse();
});
