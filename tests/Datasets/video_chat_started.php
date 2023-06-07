<?php

dataset('video_chat_started', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/video_chat_started.json');

    return [json_decode($file)];
});
