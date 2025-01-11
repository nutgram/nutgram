<?php

declare(strict_types=1);

dataset('command_tags', fn () => [
    'empty' => [json_decode(file_get_contents(__DIR__.'/../Fixtures/Updates/command.json')), true],
    'valid' => [json_decode(file_get_contents(__DIR__.'/../Fixtures/Updates/command_tag_valid.json')), true],
    'wrong' => [json_decode(file_get_contents(__DIR__.'/../Fixtures/Updates/command_tag_wrong.json')), false],
]);
