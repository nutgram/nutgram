<?php

use Psr\Clock\ClockInterface;
use SergiX44\Container\Container;
use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\ProgressType;
use SergiX44\Nutgram\Support\Progress\Triggers\EveryByte;
use SergiX44\Nutgram\Support\Progress\Triggers\EveryMillisecond;
use SergiX44\Nutgram\Support\Progress\Triggers\EveryPercent;
use SergiX44\Nutgram\Support\Progress\Triggers\EverySecond;
use SergiX44\Nutgram\Testing\TestClock;

function rangeProgress(int $until = 10): array
{
    return array_map(
        fn ($current) => new Progress($until, $current, ProgressType::Upload),
        range(1, $until)
    );
}

test('use EveryBytes(1)', function () {
    $trigger = new EveryByte();

    $results = array_map(
        callback: fn ($progress) => $trigger->handle($progress, new Container()),
        array: rangeProgress(),
    );

    expect($results)->toBe([
        true,  // 1
        true,  // 2
        true,  // 3
        true,  // 4
        true,  // 5
        true,  // 6
        true,  // 7
        true,  // 8
        true,  // 9
        true,  // 10
    ]);
});

test('use EveryBytes(5)', function () {
    $trigger = new EveryByte(5);

    $results = array_map(
        callback: fn ($progress) => $trigger->handle($progress, new Container()),
        array: rangeProgress(),
    );

    expect($results)->toBe([
        false,  // 1
        false,  // 2
        false,  // 3
        false,  // 4
        true,   // 5
        false,  // 6
        false,  // 7
        false,  // 8
        false,  // 9
        true,   // 10
    ]);
});

test('use EveryPercent(20)', function () {
    $trigger = new EveryPercent(20);

    $results = array_map(
        callback: fn ($progress) => $trigger->handle($progress, new Container()),
        array: rangeProgress(),
    );

    expect($results)->toBe([
        false,  // 1  => 10%
        true,  // 2  => 20%
        false,  // 3  => 30%
        true,  // 4  => 40%
        false,   // 5  => 50%
        true,  // 6  => 60%
        false,  // 7  => 70%
        true,  // 8  => 80%
        false,  // 9  => 90%
        true,   // 10 => 100%
    ]);
});

test('use EverySeconds(5)', function () {
    $container = new Container();
    $container->singleton(ClockInterface::class, new TestClock());
    $progress = new Progress(1, 10, ProgressType::Upload);

    $trigger = new EverySecond(5);

    TestClock::freeze();

    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);

    TestClock::modify('+1 second');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(false);

    TestClock::modify('+4 seconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);

    TestClock::modify('+1 second');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(false);

    TestClock::modify('+4 seconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);
});

test('use everyMilliseconds(500)', function () {
    $container = new Container();
    $container->singleton(ClockInterface::class, new TestClock());
    $progress = new Progress(1, 10, ProgressType::Upload);

    $trigger = new EveryMillisecond(500);

    TestClock::freeze();

    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);

    TestClock::modify('+100 milliseconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(false);

    TestClock::modify('+400 milliseconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);

    TestClock::modify('+100 milliseconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(false);

    TestClock::modify('+400 milliseconds');
    $result = $trigger->handle($progress, $container);
    expect($result)->toBe(true);
});
