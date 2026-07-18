<?php

dataset('community_chat_added', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/community_chat_added.json');

    return [json_decode($file)];
});
