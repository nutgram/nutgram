<?php

dataset('message_topic', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_topic.json');

    return [json_decode($file)];
});
