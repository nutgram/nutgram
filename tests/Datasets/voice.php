<?php

dataset('voice', function () {
    $file = file_get_contents(__DIR__.'/../Updates/voice.json');

    return [json_decode($file)];
});
