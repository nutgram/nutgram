<?php

declare(strict_types=1);

dataset('passport_data', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/passport_data.json');

    return [json_decode($file)];
});
