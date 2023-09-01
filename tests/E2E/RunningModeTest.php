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

it('works with webhook mode with safe mode and wrong secret', function () {
    $this->expectNotToPerformAssertions();

    $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] = 'foo';

    $bot = Nutgram::fake();

    $mock = mock(Webhook::class, [null, 'bar'])
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

    $mock->setSafeMode(true);

    $bot->setRunningMode($mock);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot)->toBeInstanceOf(Nutgram::class);
    });

    $bot->run();
});

it('works with webhook mode with safe mode and right secret', function () {
    $bot = Nutgram::fake();

    $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] = 'foo';

    $mock = mock(Webhook::class, [null, 'foo'])
        ->shouldAllowMockingProtectedMethods()
        ->shouldReceive('input')
        ->andReturn(file_get_contents(__DIR__.'/../Fixtures/Updates/message.json'))
        ->getMock()
        ->makePartial();

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
    Polling::$STDERR = fopen('php://memory', 'rb+');

    $bot->setRunningMode(Polling::class);

    $called = false;
    $bot->onMessage(function (Nutgram $bot) use (&$called) {
        Polling::$FOREVER = false;
        $called = true;
        throw new RuntimeException('stop!');
    });

    $bot->run();

    rewind(Polling::$STDERR);
    expect($called)->toBeTrue()
        ->and(stream_get_contents(Polling::$STDERR))->toContain('stop!');
})->with('message');

it('works with send as response', function ($update) {
    $bot = Nutgram::fake($update);

    if (!function_exists('fastcgi_finish_request')) {
        function fastcgi_finish_request()
        {
            return true;
        }
    }

    $bot->onText('Ciao', function (Nutgram $bot) {
        ob_start();
        $u = $bot->asResponse()->sendMessage('Hello');
        $contents = ob_get_contents();
        ob_end_clean();
        expect($u)->toBeNull()
            ->and($contents)->toBe('{"method":"sendMessage","chat_id":456,"text":"Hello"}');
    });

    $bot->willReceivePartial([
        'message' => [
            'text' => 'Ciao',
        ],
    ])->reply();
})->with('message');
