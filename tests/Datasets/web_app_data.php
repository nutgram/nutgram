<?php

declare(strict_types=1);

dataset('web_app_data', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/web_app_data.json');

    return [json_decode($file)];
});
