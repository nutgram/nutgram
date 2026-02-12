<?php
declare(strict_types=1);

use SergiX44\Nutgram\Testing\TestClock;

afterEach(function () {
    TestClock::unfreeze();
});

it('returns current time when not freezed', function () {
    $clock = new TestClock();
    $now = new DateTimeImmutable();

    // allow 1 second difference for execution time
    expect($clock->now()->getTimestamp())->toBeGreaterThanOrEqual($now->getTimestamp());
});

it('can freeze the clock with "now"', function () {
    $clock = new TestClock();
    TestClock::freeze();

    $frozen = $clock->now();
    usleep(1000); // Wait a bit

    expect(TestClock::isFreezed())->toBeTrue()
        ->and($clock->now())->toEqual($frozen);
});

it('can freeze the clock with a specific string', function () {
    $clock = new TestClock();
    $dateStr = '2023-01-01 12:00:00';
    TestClock::freeze($dateStr);

    expect($clock->now()->format('Y-m-d H:i:s'))->toBe($dateStr);
});

it('can freeze the clock with a DateTimeImmutable', function () {
    $clock = new TestClock();
    $date = new DateTimeImmutable('2023-05-05 10:00:00');
    TestClock::freeze($date);

    expect($clock->now())->toEqual($date);
});

it('can unfreeze the clock', function () {
    TestClock::freeze();
    expect(TestClock::isFreezed())->toBeTrue();

    TestClock::unfreeze();
    expect(TestClock::isFreezed())->toBeFalse();
});

it('can get the freezed time', function () {
    $dateStr = '2023-01-01 12:00:00';
    TestClock::freeze($dateStr);

    expect(TestClock::getFreezedTime()?->format('Y-m-d H:i:s'))->toBe($dateStr);
});

it('returns null for freezed time if not freezed', function () {
    TestClock::unfreeze();
    expect(TestClock::getFreezedTime())->toBeNull();
});

it('can sleep the clock when freezed', function () {
    $clock = new TestClock();
    TestClock::freeze('2023-01-01 12:00:00');

    TestClock::sleep(60);

    expect($clock->now()->format('Y-m-d H:i:s'))->toBe('2023-01-01 12:01:00');
});

it('throws exception when sleeping if not freezed', function () {
    TestClock::unfreeze();
    TestClock::sleep(60);
})->throws(RuntimeException::class, 'Cannot sleep when clock is not freezed');

it('can modify the clock when freezed', function () {
    $clock = new TestClock();
    TestClock::freeze('2023-01-01 12:00:00');

    TestClock::modify('+1 day');

    expect($clock->now()->format('Y-m-d H:i:s'))->toBe('2023-01-02 12:00:00');
});

it('throws exception when modifying if not freezed', function () {
    TestClock::unfreeze();
    TestClock::modify('+1 day');
})->throws(RuntimeException::class, 'Cannot modify when clock is not freezed');

it('throws exception for invalid modifier', function () {
    TestClock::freeze();
    TestClock::modify('invalid-modifier');
})->throws(InvalidArgumentException::class);
