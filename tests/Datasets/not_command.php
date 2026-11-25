<?php

declare(strict_types=1);

dataset('not_command', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/not_command.json');

    return [json_decode($file)];
});
