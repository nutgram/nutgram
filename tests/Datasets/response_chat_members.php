<?php

dataset('response_chat_members', function () {
    $file = file_get_contents(__DIR__.'/../Responses/chat_members.json');
    return [$file];
});
