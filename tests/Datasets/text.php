<?php

declare(strict_types=1);

dataset('text', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/text.json');

    return [json_decode($file)];
});
