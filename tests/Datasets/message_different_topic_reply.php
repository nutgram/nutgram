<?php

declare(strict_types=1);

dataset('message_different_topic_reply', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_different_topic_reply.json');

    return [json_decode($file)];
});
