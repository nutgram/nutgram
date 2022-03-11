<?php

use SergiX44\Nutgram\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)
    ->group('Features')
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

//expect()->extend('toBeOne', function () {
//    return $this->toBe(1);
//});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

dataset('message', function () {
    $file = file_get_contents(__DIR__.'/Updates/message.json');

    return [json_decode($file)];
});

dataset('command_message', function () {
    $file = file_get_contents(__DIR__.'/Updates/command_message.json');

    return [json_decode($file)];
});

dataset('callback_query', function () {
    $file = file_get_contents(__DIR__.'/Updates/callback_query.json');

    return [json_decode($file)];
});

dataset('edited_message', function () {
    $file = file_get_contents(__DIR__.'/Updates/edited_message.json');

    return [json_decode($file)];
});

dataset('photo', function () {
    $file = file_get_contents(__DIR__.'/Updates/photo.json');

    return [json_decode($file)];
});

dataset('text', function () {
    $file = file_get_contents(__DIR__.'/Updates/text.json');

    return [json_decode($file)];
});

dataset('command', function () {
    $file = file_get_contents(__DIR__.'/Updates/command.json');

    return [json_decode($file)];
});

dataset('not_command', function () {
    $file = file_get_contents(__DIR__.'/Updates/not_command.json');

    return [json_decode($file)];
});

dataset('response_user_deactivated', function () {
    $file = file_get_contents(__DIR__.'/Responses/user_deactivated.json');
    return [$file];
});

dataset('response_wrong_file_id', function () {
    $file = file_get_contents(__DIR__.'/Responses/wrong_file_id.json');

    return [$file];
});
