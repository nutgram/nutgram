<?php

declare(strict_types=1);

dataset('poll_answer', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/poll_answer.json');

    return [json_decode($file)];
});
