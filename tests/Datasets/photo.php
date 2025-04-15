<?php

declare(strict_types=1);

dataset('photo', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/photo.json');

    return [json_decode($file)];
});
