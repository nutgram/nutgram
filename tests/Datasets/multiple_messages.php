<?php

dataset('multiple_messages', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message.json');

    return [[[json_decode($file), json_decode($file)]]];
});
