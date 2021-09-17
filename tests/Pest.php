<?php

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

uses()->group('Features')->in('Feature');
// uses(Tests\TestCase::class)->in('Feature');

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

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\TestingRunningMode;

function getInstance($update = null): Nutgram
{
    $bot = new Nutgram($_ENV['TOKEN'] ?? 'FAKE');
    $bot->setRunningMode(new TestingRunningMode($update));

    return $bot;
}

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
