<?php

declare(strict_types=1);

dataset('response_user_deactivated', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/user_deactivated.json');
    return [$file];
});
