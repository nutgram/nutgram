<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\CommandWithNamedParameter;

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

it('calls handler with different pattern cases', function ($pattern, $input, $pass) {
    $bot = Nutgram::fake();

    $bot->onText($pattern, function (Nutgram $bot) {
        $bot->sendMessage('called');
    });

    $bot->hearText($input)->reply();

    expect($bot)
        ->when($pass, fn ($bot) => $bot->assertCalled('sendMessage'))
        ->unless($pass, fn ($bot) => $bot->assertNoReply());
})->with([
    'latin-lower-lower' => ['foo', 'foo', true],
    'latin-lower-upper' => ['foo', 'FOO', false],
    'latin-upper-lower' => ['FOO', 'foo', false],
    'latin-upper-upper' => ['FOO', 'FOO', true],
    'cyrillic-lower-lower' => ['пример', 'пример', true],
    'cyrillic-lower-upper' => ['пример', 'ПРИМЕР', false],
    'cyrillic-upper-lower' => ['ПРИМЕР', 'пример', false],
    'cyrillic-upper-upper' => ['ПРИМЕР', 'ПРИМЕР', true],
]);


it('calls handler with optional regex group', function (string $hear, ?string $expected) {
    $bot = Nutgram::fake();

    $bot->onCommand('start ?(.*)?', function (Nutgram $bot, ?string $param) use ($expected) {
        expect($param)->toBe($expected);
    });

    $bot->hearText($hear)->reply();
})->with([
    'without-param' => ['/start', null],
    'with-param' => ['/start foo', 'foo'],
]);

it('does not call similar pattern', function (string $hear) {
    $bot = Nutgram::fake();

    $bot->onText('ping', fn (Nutgram $bot) => $bot->sendMessage('ping'));
    $bot->onText('pin', fn (Nutgram $bot) => $bot->sendMessage('pin'));

    $bot->hearText($hear)
        ->reply()
        ->assertReplyText($hear)
        ->assertCalled('sendMessage');
})->with(['ping', 'pin']);

it('calls handler with optional named parameter', function (string $hear, string $constraint, bool $expected) {
    $bot = Nutgram::fake();

    $called = false;
    $bot->onCommand('start {value}', function (Nutgram $bot, string $param) use (&$called) {
        $called = true;
    })->where('value', $constraint);

    $bot->hearText($hear)->reply();
    expect($called)->toBe($expected);
})->with([
    'word-ok' => ['/start hello', '[a-z]+', true],
    'word-ko' => ['/start 123', '[a-z]+', false],
    'numeric-ok' => ['/start 123', '\d+', true],
    'numeric-ko' => ['/start hello', '\d+', false],
    'letter-number-ok' => ['/start a1', '[a-z]\d', true],
    'letter-number-ko' => ['/start hello', '[a-z]\d', false],
]);

it(
    'calls handler with optional named parameter using command class',
    function (string $hear, string $constraint, bool $expected) {
        $bot = Nutgram::fake();

        $bot->registerCommand(CommandWithNamedParameter::class);

        $bot->hearText($hear)->reply();

        expect($bot->get('called', false))->toBe($expected);
    }
)->with([
    'valid' => ['/start hello', '[a-z]+', true],
    'invalid' => ['/start 123', '[a-z]+', false],
]);

it('calls handler with optional named parameters', function (string $hear, bool $expected) {
    $bot = Nutgram::fake();

    $called = false;
    $bot->onCommand('start {name} {age}', function (Nutgram $bot) use (&$called) {
        $called = true;
    })->where(['name' => '[a-z]+', 'age' => '\d+']);

    $bot->hearText($hear)->reply();
    expect($called)->toBe($expected);
})->with([
    'valid' => ['/start luke 4316', true],
    'invalid' => ['/start 4316 luke', false],
]);
