<?php

dataset('command', function () {
    $file = file_get_contents(__DIR__.'/../Updates/command.json');

    return [json_decode($file)];
});
