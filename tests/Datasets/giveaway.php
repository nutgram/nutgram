<?php

declare(strict_types=1);

dataset('giveaway', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/giveaway.json');

    return [json_decode($file)];
});
