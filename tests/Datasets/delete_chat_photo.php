<?php

dataset('delete_chat_photo', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/delete_chat_photo.json');

    return [json_decode($file)];
});
