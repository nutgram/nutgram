<?php

dataset('subscription', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/subscription.json');

    return [json_decode($file)];
});
