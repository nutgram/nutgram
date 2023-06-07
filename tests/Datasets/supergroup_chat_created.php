<?php

dataset('supergroup_chat_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/supergroup_chat_created.json');

    return [json_decode($file)];
});
