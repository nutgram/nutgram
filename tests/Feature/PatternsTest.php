<?php

use SergiX44\Nutgram\Nutgram;

it('calls the command handler with valid regex', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCommand('register (\w+) (.*)', function (Nutgram $bot, $role, $name) {
        $bot->setGlobalData('passed', true);
        expect($role)->toBe('HR');
        expect($name)->toBe('John Doe');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('command_with_parameters');

it('calls the command handler with adjacent parameters', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCommand('register {role} {name}', function (Nutgram $bot, $role, $name) {
        $bot->setGlobalData('passed', true);
        expect($role)->toBe('HR');
        expect($name)->toBe('John Doe');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('command_with_parameters');

it('calls the message handler with full text', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want 12 portions of pizza', function (Nutgram $bot) {
        $bot->setGlobalData('passed', true);
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');

it('calls the message handler with partial - first', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I {verb} {what}', function (Nutgram $bot, $verb, $what) {
        $bot->setGlobalData('passed', true);
        expect($verb)->toBe('want');
        expect($what)->toBe('12 portions of pizza');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');

it('calls the message handler with partial - middle', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want {n} portions of pizza', function (Nutgram $bot, $n) {
        $bot->setGlobalData('passed', true);
        expect($n)->toBe('12');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');

it('calls the message handler with partial - middle together', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want {n} {what} of pizza', function (Nutgram $bot, $n, $what) {
        $bot->setGlobalData('passed', true);
        expect($n)->toBe('12');
        expect($what)->toBe('portions');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');

it('calls the message handler with partial - last', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want 12 portions {prep} {dish}', function (Nutgram $bot, $prep, $dish) {
        $bot->setGlobalData('passed', true);
        expect($prep)->toBe('of');
        expect($dish)->toBe('pizza');
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');

it('calls the message handler with regex groups', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want ([0-9]+) portions of (pizza|cake)', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with parameters', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want {amount} portions of {dish}', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with regex quantifiers #1', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want ([0-9]{2}) portions of ([a-z]{5})', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with regex quantifiers #2', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want ([0-9]{1,}) portions of ([a-z]{1,})', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with regex quantifiers #3', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want ([0-9]{1,2}) portions of ([a-z]{1,5})', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with regex groups + number', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('I want {number} portions of (pizza|cake)', function (Nutgram $bot, $amount, $dish) {
        $bot->sendMessage("You will get {$amount} portions of {$dish}!");

        expect($amount)->toBe('12');
        expect($dish)->toBe('pizza');
    });

    $bot->run();
})->with('food');

it('calls the message handler with regex all characters', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('.*', function ($bot) {
        $bot->setGlobalData('passed', true);
    });

    $bot->run();

    expect($bot->getGlobalData('passed', false))->toBeTrue();
})->with('food');
