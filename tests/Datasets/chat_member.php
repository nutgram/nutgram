<?php

dataset('chat_member', function () {
    $file = file_get_contents(__DIR__.'/../Updates/chat_member.json');

    return [json_decode($file)];
});
