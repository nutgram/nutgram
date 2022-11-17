<?php

dataset('video_chat_scheduled', function () {
    $file = file_get_contents(__DIR__.'/../Updates/video_chat_scheduled.json');

    return [json_decode($file)];
});
