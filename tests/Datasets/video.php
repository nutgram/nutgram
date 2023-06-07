<?php

dataset('video', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/video.json');

    return [json_decode($file)];
});
