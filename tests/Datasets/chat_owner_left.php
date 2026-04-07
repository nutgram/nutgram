<?php

dataset('chat_owner_left', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/chat_owner_left.json');

    return [json_decode($file)];
});
