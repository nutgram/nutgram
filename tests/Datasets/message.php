<?php

declare(strict_types=1);

dataset('message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message.json');

    return [json_decode($file)];
});
