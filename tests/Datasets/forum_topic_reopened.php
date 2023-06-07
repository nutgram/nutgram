<?php

dataset('forum_topic_reopened', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/forum_topic_reopened.json');

    return [json_decode($file)];
});
