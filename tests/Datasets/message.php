<?php

dataset('message', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message.json');

    return [json_decode($file)];
});
