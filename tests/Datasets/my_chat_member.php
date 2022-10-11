<?php

dataset('my_chat_member', function () {
    $file = file_get_contents(__DIR__.'/../Updates/my_chat_member.json');

    return [json_decode($file)];
});
