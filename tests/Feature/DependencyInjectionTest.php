<?php

use SergiX44\Container\Container;
use SergiX44\Container\Exception\ContainerException;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithConstructor;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;
use SergiX44\Nutgram\Tests\Fixtures\DI\MiddlewareCallable;
use SergiX44\Nutgram\Tests\Fixtures\DI\StartCommandCallable;
use SergiX44\Nutgram\Tests\Fixtures\DI\StartCommandClassConstructor;
use SergiX44\Nutgram\Tests\Fixtures\DI\StartCommandClassHandle;
use SergiX44\Nutgram\Tests\Fixtures\DI\TextHandlerCallable;
use SergiX44\Nutgram\Tests\Fixtures\MyService;
use SergiX44\Nutgram\Tests\Fixtures\ServiceHandler;

it('uses a different container', function () {
    $differentContainer = new Container();
    $differentContainer->singleton(MyService::class, fn () => new MyService('hello'));

    $bot = Nutgram::fake(config: new Configuration(
        container: $differentContainer
    ));

    $bot->onCommand('test', ServiceHandler::class);

    $bot->hearText('/test')
        ->reply()
        ->assertReplyText('hello');
});

it('throws an exception when resolving an invalid callable', function () {
    $bot = Nutgram::fake();

    $bot->onText('foo', 123);

    $bot->hearText('foo')->reply();
})->throws(ContainerException::class, 'Invalid callable specified');

describe('DI in Command', function () {
    test('closure', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->onCommand('start {value}', function (Nutgram $bot, string $value, CustomService $service) {
            expect($value)->toBe('foo');
            expect($service)->toBeInstanceOf(CustomService::class);
        });

        $bot->hearText('/start foo')->reply();
    });

    test('callable', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->onCommand('start {value}', StartCommandCallable::class);

        $bot->hearText('/start foo')->reply();
    });

    test('class + handle', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->registerCommand(StartCommandClassHandle::class);

        $bot->hearText('/start foo')->reply();
    });

    test('class + constructor', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->registerCommand(StartCommandClassConstructor::class);

        $bot->hearText('/start foo')->reply();
    });
});

describe('DI in Handler', function () {
    test('closure', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());
        $bot->getContainer()->set(MyService::class, new MyService('hello'));

        $bot->onText('foo', function (Nutgram $bot, CustomService $service1, MyService $Service2) {
            expect($service1)->toBeInstanceOf(CustomService::class);
            expect($Service2)->toBeInstanceOf(MyService::class);
        });

        $bot->hearText('foo')->reply();
    });

    test('callable', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());
        $bot->getContainer()->set(MyService::class, new MyService('hello'));

        $bot->onText('foo', TextHandlerCallable::class);

        $bot->hearText('foo')->reply();
    });
});

describe('DI in Middleware', function () {
    test('closure', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->onText('name {value}', function (Nutgram $bot, string $value) {
            expect($value)->toBe('foo');
        })->middleware(function (Nutgram $bot, $next, CustomService $service) {
            expect($service)->toBeInstanceOf(CustomService::class);
            $next($bot);
        });

        $bot->hearText('name foo')->reply();
    });

    test('callable', function () {
        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->onText('name {value}', function (Nutgram $bot, string $value) {
            expect($value)->toBe('foo');
        })->middleware(MiddlewareCallable::class);

        $bot->hearText('name foo')->reply();
    });
});

describe('DI in Conversation', function () {
    it('callable', function () {
        Conversation::refreshOnDeserialize();

        $bot = Nutgram::fake();
        $bot->getContainer()->set(CustomService::class, new CustomService());

        $bot->onMessage(ConversationWithConstructor::class);

        $bot->willStartConversation();

        $bot->hearText('foo')->reply();
        expect($bot->get('test'))->toBe(1);

        $bot->hearText('foo')->reply();
        expect($bot->get('test'))->toBe(2);

        Conversation::refreshOnDeserialize(false);
    });
});

it('resolves a parameter with custom resolution logic', function () {
    $bot = Nutgram::fake();
    $bot->bindParameter('value', function (Container $container, string $value) {
        return new MyService('wrapped:'.$value);
    });

    $bot->onCommand('start {value} (y|n) {cat}', function (Nutgram $bot, MyService $value) {
        expect($value)
            ->toBeInstanceOf(MyService::class)
            ->getValue()
            ->toBe('wrapped:123');
    });

    $bot->hearText('/start 123 y aaa')->reply();
});
