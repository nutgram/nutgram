<?php

declare(strict_types=1);

dataset('audio', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/audio.json');

    return [json_decode($file)];
});
