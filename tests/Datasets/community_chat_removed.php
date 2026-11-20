<?php

dataset('community_chat_removed', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/community_chat_removed.json');

    return [json_decode($file)];
});
