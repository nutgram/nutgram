<?php

declare(strict_types=1);

dataset('inline_query', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/inline_query.json');

    return [json_decode($file)];
});
