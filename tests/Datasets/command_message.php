<?php

declare(strict_types=1);

dataset('command_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/command_message.json');

    return [json_decode($file)];
});
