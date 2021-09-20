<?php

test('isCommand returns true on command input', function ($update) {
    $bot = getInstance($update);

    $bot->run();

    expect($bot->isCommand())->toBeTrue();

})->with('command');

test('isCommand returns false on command inside a text', function ($update) {
    $bot = getInstance($update);

    $bot->run();

    expect($bot->isCommand())->toBeFalse();

})->with('not_command');

test('isCommand returns false on text', function ($update) {
    $bot = getInstance($update);

    $bot->run();

    expect($bot->isCommand())->toBeFalse();

})->with('text');
