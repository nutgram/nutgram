<?php

dataset('video_chat_participants_invited', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/video_chat_participants_invited.json');

    return [json_decode($file)];
});
