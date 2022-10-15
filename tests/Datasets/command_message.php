<?php

dataset('command_message', function () {
    $file = file_get_contents(__DIR__.'/../Updates/command_message.json');

    return [json_decode($file)];
});
