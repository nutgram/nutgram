<?php

dataset('message_different_topic', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_different_topic.json');

    return [json_decode($file)];
});
