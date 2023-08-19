<?php

dataset('story', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/story.json');

    return [json_decode($file)];
});
