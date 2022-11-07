<?php

dataset('command_tags', function () {
    return [
        'empty' => [json_decode(file_get_contents(__DIR__.'/../Updates/command.json')), true],
        'valid' => [json_decode(file_get_contents(__DIR__.'/../Updates/command_tag_valid.json')), true],
        'wrong' => [json_decode(file_get_contents(__DIR__.'/../Updates/command_tag_wrong.json')), false],
    ];
});
