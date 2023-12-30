<?php

dataset('removed_chat_boost', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/removed_chat_boost.json');

    return [json_decode($file)];
});
