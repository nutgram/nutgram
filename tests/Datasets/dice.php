<?php

dataset('dice', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/dice.json');

    return [json_decode($file)];
});
