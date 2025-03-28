<?php

declare(strict_types=1);

dataset('food', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/food.json');

    return [json_decode($file)];
});
