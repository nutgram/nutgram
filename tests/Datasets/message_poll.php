<?php

dataset('message_poll', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message_poll.json');

    return [json_decode($file)];
});
