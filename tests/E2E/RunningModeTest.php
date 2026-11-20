<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\RespondsToWebhook;
use SergiX44\Nutgram\RunningMode\SingleUpdate;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

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

    try {
        $bot->run();
    } catch (\Throwable $th) {
        // ssshhhh
    }


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

function respondingRunningMode(mixed $update): Fake&RespondsToWebhook
{
    return new class($update) extends Fake implements RespondsToWebhook {
        public bool $accepting = true;

        /** @var list<array{string, array<array-key, mixed>}> */
        public array $responses = [];

        public function canRespond(): bool
        {
            return $this->accepting;
        }

        public function respond(string $method, array $parameters): void
        {
            $this->responses[] = [$method, $parameters];
        }
    };
}

it('sends the request as the webhook response when the running mode can respond', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->setRunningMode($runningMode = respondingRunningMode($update));

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot->asResponse()->sendMessage('Hello', parse_mode: ParseMode::HTML))->toBeNull();
    });

    $bot->reply()->assertNoReply();

    expect($runningMode->responses)->toBe([
        ['sendMessage', ['chat_id' => 456, 'text' => 'Hello', 'parse_mode' => 'HTML']],
    ]);
})->with('message');

it('sends a normal request when the running mode cannot respond', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        expect($bot->asResponse()->sendMessage('Hello'))->toBeInstanceOf(Message::class);
    });

    $bot->reply()->assertReply('sendMessage', ['chat_id' => 456, 'text' => 'Hello']);
})->with('message');

it('applies asResponse to the next request only', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->setRunningMode($runningMode = respondingRunningMode($update));

    $bot->onText('Ciao', function (Nutgram $bot) use ($runningMode) {
        $runningMode->accepting = false;
        $bot->asResponse()->sendMessage('Hello');

        $runningMode->accepting = true;
        $bot->sendMessage('World');
    });

    $bot->reply()->assertCalled('sendMessage', 2);

    expect($runningMode->responses)->toBe([]);
})->with('message');

it('does not send a multipart request as the webhook response', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->setRunningMode($runningMode = respondingRunningMode($update));

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->asResponse()->sendDocument(InputFile::make(fopen('php://temp', 'rb'), 'document.txt'));
        $bot->sendMessage('Hello');
    });

    $bot->reply()
        ->assertCalled('sendDocument')
        ->assertCalled('sendMessage');

    expect($runningMode->responses)->toBe([]);
})->with('message');

it('echoes the webhook response in webhook mode', function () {
    if (!function_exists('fastcgi_finish_request')) {
        function fastcgi_finish_request()
        {
            return true;
        }
    }

    ob_start();
    (new Webhook())->respond('sendMessage', ['chat_id' => 456, 'text' => 'Hello']);

    expect(ob_get_clean())->toBe('{"method":"sendMessage","chat_id":456,"text":"Hello"}');
});

it('works with single update running mode', function ($update) {
    $update->update_id = 100;

    $bot = Nutgram::fake()
        ->willReceive([$update])
        ->willReceive([$update]);

    $bot->setRunningMode(SingleUpdate::class);

    $called = false;
    $bot->onMessage(function (Nutgram $bot) use (&$called) {
        $called = true;
    });

    $bot->run();

    expect($called)->toBeTrue();
})->with('message');
