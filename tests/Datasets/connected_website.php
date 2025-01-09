<?php

declare(strict_types=1);

dataset('connected_website', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/connected_website.json');

    return [json_decode($file)];
});
