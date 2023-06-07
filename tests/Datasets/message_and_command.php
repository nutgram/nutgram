<?php

dataset('message_and_command', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/command_message.json');
    $file2 = file_get_contents(__DIR__.'/../Fixtures/Updates/message.json');

    return [[json_decode($file2), json_decode($file)]];
});
