<?php

dataset('not_command', function () {
    $file = file_get_contents(__DIR__.'/../Updates/not_command.json');

    return [json_decode($file)];
});
