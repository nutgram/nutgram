<?php

dataset('sticker', function () {
    $file = file_get_contents(__DIR__.'/../Updates/sticker.json');

    return [json_decode($file)];
});
