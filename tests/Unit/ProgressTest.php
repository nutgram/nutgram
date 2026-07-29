<?php

use SergiX44\Nutgram\Support\Progress\Progress;
use SergiX44\Nutgram\Support\Progress\ProgressType;

test('get properties', function () {
    $progress = new Progress(1000, 100, ProgressType::Upload);

    expect($progress->totalBytes)->toBe(1000)
        ->and($progress->currentBytes)->toBe(100)
        ->and($progress->type)->toBe(ProgressType::Upload);
});

test('get percentage', function (int $total, int $current, int $precision, int|float $expected) {
    $progress = new Progress($total, $current, ProgressType::Upload);

    expect($progress->percentage($precision))->toBe($expected);
})->with([
    [1000, 100, 0, 10],
    [1000, 100, 1, 10.0],
    [1000, 100, 2, 10.00],
    [1500, 350, 0, 23],
    [1500, 350, 1, 23.3],
    [1500, 350, 2, 23.33],
]);
