<?php

dataset('message_general_topic', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_general_topic.json');

    return [json_decode($file)];
});
