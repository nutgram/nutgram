<?php

dataset('video_note', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/video_note.json');

    return [json_decode($file)];
});
