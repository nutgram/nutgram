<?php

declare(strict_types=1);

dataset('pre_checkout_query', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/pre_checkout_query.json');

    return [json_decode($file)];
});
