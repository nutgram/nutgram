<?php

use Illuminate\Support\Str;
use SergiX44\Nutgram\Logger\ConsoleLogger;
use SergiX44\Nutgram\Nutgram;

it('does not log with ConsoleLogger if script is not running in cli mode', function () {
    $logger = mock(ConsoleLogger::class)
        ->shouldAllowMockingProtectedMethods()
        ->makePartial()
        ->shouldReceive('isCli')
        ->andReturn(false)
        ->getMock();

    $logger->debug('info');

    expect(ob_get_contents())->toBeEmpty();
});

it('logs with ConsoleLogger', function ($input, $expected) {
    $bot = Nutgram::fake(config: ['logger' => ConsoleLogger::class]);

    $bot->getContainer()->get(ConsoleLogger::class)->debug($input);

    expect(ob_get_contents())->toContain($expected);
})->with([
    'string' => ['foo', 'DEBUG: foo'],
    'stringable' => [Str::of('bar'), 'DEBUG: bar'],
]);
