<?php

declare(strict_types=1);

dataset('location', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/location.json');

    return [json_decode($file)];
});
