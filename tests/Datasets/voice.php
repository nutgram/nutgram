<?php

declare(strict_types=1);

dataset('voice', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/voice.json');

    return [json_decode($file)];
});
