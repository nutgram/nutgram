<?php

dataset('forum_topic_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/forum_topic_created.json');

    return [json_decode($file)];
});
