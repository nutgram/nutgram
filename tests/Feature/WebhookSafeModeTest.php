<?php

use SergiX44\Nutgram\RunningMode\Webhook;

it('can detect fake requests to webhook url from ipv4', function () {
    $webhook = new Webhook();

    $webhook->setSafeMode(true); // Activate safe mode

    $_SERVER['REMOTE_ADDR'] = '190.14.25.47'; // fake ip address
    expect($webhook->isSafeIpv4())->toBeFalse();

    $_SERVER['REMOTE_ADDR'] = '2a0e:415:3faf:0:abab:6cd1:56a:460a'; // fake ip address
    expect($webhook->isSafeIpv4())->toBeFalse();

    $_SERVER['REMOTE_ADDR'] = '91.108.4.5'; // a Telegram ip address
    expect($webhook->isSafeIpv4())->toBeTrue();
});

it('resolves ip with the closure', function () {
    $webhook = new Webhook();

    $webhook->setSafeMode(true)
        ->requestIpFrom(function () {
            return '91.108.4.5'; // return the ip in another way
        });

    $_SERVER['REMOTE_ADDR'] = '1.1.1.1'; // fake ip address
    expect($webhook->isSafeIpv4())->toBeTrue();
});
