<?php

use SergiX44\Nutgram\Configuration;
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

it('logs with ConsoleLogger (with string)', function () {
    $bot = Nutgram::fake(config: new Configuration(logger: ConsoleLogger::class));

    $bot->getContainer()->get(ConsoleLogger::class)->debug('foo');

    expect(ob_get_contents())->toContain('DEBUG: foo');
});

it('logs with ConsoleLogger (with stringable)', function () {
    $bot = Nutgram::fake(config: new Configuration(logger: ConsoleLogger::class));

    $input = new class implements Stringable {
        public function __toString(): string
        {
            return 'bar';
        }
    };

    $bot->getContainer()->get(ConsoleLogger::class)->debug($input);

    expect(ob_get_contents())->toContain('DEBUG: bar');
});
