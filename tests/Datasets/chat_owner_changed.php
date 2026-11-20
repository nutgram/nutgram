<?php

dataset('chat_owner_changed', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/chat_owner_changed.json');

    return [json_decode($file)];
});
