<?php

dataset('text', function () {
    $file = file_get_contents(__DIR__.'/../Updates/text.json');

    return [json_decode($file)];
});
