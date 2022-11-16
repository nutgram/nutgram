<?php

dataset('audio', function () {
    $file = file_get_contents(__DIR__.'/../Updates/audio.json');

    return [json_decode($file)];
});
