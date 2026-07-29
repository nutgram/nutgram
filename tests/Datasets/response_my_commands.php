<?php

declare(strict_types=1);

dataset('response_my_commands', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/my_commands.json');
    return [$file];
});
