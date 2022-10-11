<?php

dataset('message_and_command', function () {
    $file = file_get_contents(__DIR__.'/../Updates/command_message.json');
    $file2 = file_get_contents(__DIR__.'/../Updates/message.json');

    return [[json_decode($file2), json_decode($file)]];
});
