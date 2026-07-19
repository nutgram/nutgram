<?php

declare(strict_types=1);

dataset('business_connection', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/business_connection.json');

    return [json_decode($file)];
});
