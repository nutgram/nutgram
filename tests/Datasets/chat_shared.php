<?php

dataset('chat_shared', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/chat_shared.json');

    return [json_decode($file)];
});
