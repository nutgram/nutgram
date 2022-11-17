<?php

dataset('location', function () {
    $file = file_get_contents(__DIR__.'/../Updates/location.json');

    return [json_decode($file)];
});
