<?php

declare(strict_types=1);

dataset('too_many_requests', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/too_many_requests.json');
    return [$file];
});
