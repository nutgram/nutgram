<?php

dataset('new_chat_photo', function () {
    $file = file_get_contents(__DIR__.'/../Updates/new_chat_photo.json');

    return [json_decode($file)];
});
