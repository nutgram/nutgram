<?php

dataset('channel_chat_created', function () {
    $file = file_get_contents(__DIR__.'/../Updates/channel_chat_created.json');

    return [json_decode($file)];
});
