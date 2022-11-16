<?php

dataset('migrate_to_chat_id', function () {
    $file = file_get_contents(__DIR__.'/../Updates/migrate_to_chat_id.json');

    return [json_decode($file)];
});
