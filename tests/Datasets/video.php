<?php

dataset('video', function () {
    $file = file_get_contents(__DIR__.'/../Updates/video.json');

    return [json_decode($file)];
});
