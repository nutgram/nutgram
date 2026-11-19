<?php

dataset('community_chat_joined', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/community_chat_joined.json');

    return [json_decode($file)];
});
