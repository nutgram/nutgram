<?php

dataset('video_chat_ended', function () {
    $file = file_get_contents(__DIR__.'/../Updates/video_chat_ended.json');

    return [json_decode($file)];
});
