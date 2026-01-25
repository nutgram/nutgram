<?php

declare(strict_types=1);

dataset('entities', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/entities.json');

    return [json_decode($file)];
});
