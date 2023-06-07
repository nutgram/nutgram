<?php

dataset('left_chat_member', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/left_chat_member.json');

    return [json_decode($file)];
});
