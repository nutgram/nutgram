<?php

declare(strict_types=1);

dataset('command_with_parameters', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/command_with_parameters.json');

    return [json_decode($file)];
});
