<?php

declare(strict_types=1);

dataset('callback_query_complex', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/callback_query_complex.json');

    return [json_decode($file)];
});
