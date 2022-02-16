<?php

it('can detect fake requests to webhook url ', function () {
    $webhook = new \SergiX44\Nutgram\RunningMode\Webhook();

    $webhook->setSafeMode(true); // Activate safe mode

    $_SERVER['REMOTE_ADDR'] = '190.14.25.47'; // fake ip address
    expect($webhook->isSafe())->toBeFalse();

    $_SERVER['REMOTE_ADDR'] = '91.108.4.5'; // a Telegram ip address
    expect($webhook->isSafe())->toBeTrue();
});
