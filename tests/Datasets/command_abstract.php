<?php

use SergiX44\Nutgram\Tests\Feature\OOP\TestCommand;

dataset('command_abstract', function () {
    $file = file_get_contents(__DIR__.'/../Updates/command.json');

    return [
        'class-string' => [json_decode($file), TestCommand::class, 'command called'],
        'array' => [json_decode($file), [TestCommand::class, 'suchwow'], 'such command called'],
    ];
});
