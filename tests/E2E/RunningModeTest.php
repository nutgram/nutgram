<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;

it('works with webhook mode', function () {
    $bot = Nutgram::fake();

    $mock = mock(Webhook::class)
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

    $bot->setRunningMode($mock);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot)->toBeInstanceOf(Nutgram::class);
    });

    $bot->run();
});

it('works with webhook mode with safe mode and wrong ip', function () {
    $this->expectNotToPerformAssertions();

    $bot = Nutgram::fake();

    $mock = mock(Webhook::class)
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

    $mock->requestIpFrom(fn () => '1.1.1.1');
    $mock->setSafeMode(true);

    $bot->setRunningMode($mock);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot)->toBeInstanceOf(Nutgram::class);
    });

    $bot->run();
});

it('works with webhook mode with safe mode and right ip', function () {
    $bot = Nutgram::fake();

    $mock = mock(Webhook::class)
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

    $mock->requestIpFrom(fn () => '91.108.4.1');
    $mock->setSafeMode(true);
    expect($mock->isSafeMode())->toBeTrue();

    $bot->setRunningMode($mock);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot)->toBeInstanceOf(Nutgram::class);
    });

    $bot->run();
});

it('works with webhook and empty stdin', function () {
    $this->expectNotToPerformAssertions();

    $bot = Nutgram::fake();

    $bot->setRunningMode(Webhook::class);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot)->toBeInstanceOf(Nutgram::class);
    });

    $bot->run();
});

it('works with webhook mode with exceptions', function () {
    $bot = Nutgram::fake();

    $mock = mock(Webhook::class)
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

    $bot->setRunningMode($mock);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->set('called', true);
        throw new \RuntimeException('Stop!');
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
});

it('works with polling mode', function ($update) {
    $update->update_id = 100;

    $bot = Nutgram::fake()
        ->willReceive([$update])
        ->willReceive([$update]);

    Polling::$FOREVER = true;
    $bot->setRunningMode(Polling::class);

    $called = false;
    $bot->onMessage(function (Nutgram $bot) use (&$called) {
        Polling::$FOREVER = false;
        $called = true;
    });

    $bot->run();

    expect($called)->toBeTrue();
})->with('message');

it('works with polling mode with exception', function ($update) {
    $update->update_id = 100;

    $bot = Nutgram::fake()
        ->willReceive([$update])
        ->willReceive([$update]);

    Polling::$FOREVER = true;
    $bot->setRunningMode(Polling::class);

    $called = false;
    $bot->onMessage(function (Nutgram $bot) use (&$called) {
        Polling::$FOREVER = false;
        $called = true;
        throw new RuntimeException('stop!');
    });

    $bot->run();

    expect($called)->toBeTrue();
})->with('message');
