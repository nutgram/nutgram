<?php

dataset('dice', function () {
    $file = file_get_contents(__DIR__.'/../Updates/dice.json');

    return [json_decode($file)];
});
