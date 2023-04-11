<?php

dataset('command_with_parameters', function () {
    $file = file_get_contents(__DIR__.'/../Updates/command_with_parameters.json');

    return [json_decode($file)];
});
