<?php

dataset('command', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/command.json');

    return [json_decode($file)];
});
