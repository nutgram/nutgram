<?php

dataset('message_general_topic_reply', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_general_topic_reply.json');

    return [json_decode($file)];
});
