<?php

dataset('forum_topic_edited', function () {
    $file = file_get_contents(__DIR__.'/../Updates/forum_topic_edited.json');

    return [json_decode($file)];
});
