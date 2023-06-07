<?php

dataset('food', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/food.json');

    return [json_decode($file)];
});
