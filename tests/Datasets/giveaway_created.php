<?php

declare(strict_types=1);

dataset('giveaway_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/giveaway_created.json');

    return [json_decode($file)];
});
