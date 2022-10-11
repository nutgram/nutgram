<?php

dataset('photo', function () {
    $file = file_get_contents(__DIR__.'/../Updates/photo.json');

    return [json_decode($file)];
});
