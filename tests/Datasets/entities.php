<?php

dataset('entities', function () {
    $file = file_get_contents(__DIR__.'/../Updates/entities.json');

    return [json_decode($file)];
});
