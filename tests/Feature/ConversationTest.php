<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Tests\Conversations\ConversationEmpty;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithBeforeStep;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithClosing;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithClosingMultipleSteps;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithConstructor;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithDefault;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithMissingStep;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithSkipHandlersMultipleSteps;
use SergiX44\Nutgram\Tests\Conversations\ConversationWithSkipMiddlewareMultipleSteps;
use SergiX44\Nutgram\Tests\Conversations\NonSerializableConversation;
use SergiX44\Nutgram\Tests\Conversations\OneStepNotCompletedConversation;
use SergiX44\Nutgram\Tests\Conversations\TwoStepConversation;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

it('calls the conversation steps', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(TwoStepConversation::class);
    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('calls the default conversation step', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithDefault::class);
    $bot->run();

    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('starts from an handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(function (Nutgram $bot) {
        ConversationWithDefault::begin($bot);
    });
    $bot->run();

    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('calls the closing handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosing::class);
    $bot->run();

    expect($bot->getData('test'))->toBe(2);
})->with('message');

it('calls the before step handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithBeforeStep::class);
    $bot->run();

    expect($bot->getData('test'))->toBe(2);
})->with('message');

it('calls the closing handler with multiple steps', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosingMultipleSteps::class);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(3);
})->with('message');

it('it escapes the conversation when a specific handler is matched', function ($update, $command) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosingMultipleSteps::class);
    $bot->onCommand('start', function ($bot) {
        $bot->setData('test', -1);
    });

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->setRunningMode(new Fake($command));
    $bot->run();
    expect($bot->getData('test'))->toBe(-1);
})->with('message_and_command');

it('it skips the middleware on the conversation when specified', function ($update, $command) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithSkipMiddlewareMultipleSteps::class);
    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->setData('test', $bot->getData('test', 0) + 1);
        $next($bot);
    });

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->setRunningMode(new Fake($command));
    $bot->run();
    expect($bot->getData('test'))->toBe(3);
})->with('message_and_command');

it(
    'it not escapes the conversation when a specific handler is matched because it skips handler',
    function ($update, $command) {
        $bot = Nutgram::fake($update);
        $bot->onMessage(ConversationWithSkipHandlersMultipleSteps::class);
        $bot->onCommand('start', function ($bot) {
            $bot->setData('test', -1);
        });

        $bot->run();
        expect($bot->getData('test'))->toBe(1);

        $bot->setRunningMode(new Fake($command));
        $bot->run();
        expect($bot->getData('test'))->toBe(2);
    }
)->with('message_and_command');

it('calls the same handler if not end or next step called', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(OneStepNotCompletedConversation::class);
    $bot->run();
    $bot->run();
    $bot->run();

    expect($bot->getData('test'))->toBe(4);
})->with('message');

it('calls the conversation steps without class', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage('firstStep');

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
})->with('message');

function firstStep(Nutgram $bot)
{
    $bot->setData('test', 1);
    $bot->stepConversation('secondStep');
}

function secondStep(Nutgram $bot)
{
    $bot->setData('test', 2);
    $bot->endConversation();
}

it('works with inline conversations', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->setData('test', 1);

        $bot->stepConversation(function (Nutgram $bot) {
            $bot->setData('test', 2);
            $bot->endConversation();
        });
    });

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
})->with('message');

it('does not start conversation outside of it', function () {
    $bot = Nutgram::fake();

    $bot->stepConversation(function (Nutgram $bot) {
        //foo
    });
})->throws(InvalidArgumentException::class, 'You cannot step a conversation without userId and chatId.');

it('does not end conversation outside of it', function () {
    $bot = Nutgram::fake();
    $bot->endConversation();
})->throws(InvalidArgumentException::class, 'You cannot end a conversation without userId and chatId.');

it('does not work with empty conversation class', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(ConversationEmpty::class);

    $bot->run();
})->with('message')->throws(RuntimeException::class, 'Attempt to start an empty conversation.');

it('does not work with missing step', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(ConversationWithMissingStep::class);

    $bot->run();
})->with('message')->throws(RuntimeException::class, "Conversation step 'missing' not found.");

it('calls the conversation constructor at every step', function ($update) {
    $bot = Nutgram::fake($update);
    \SergiX44\Nutgram\Conversations\Conversation::refreshOnDeserialize();
    $bot->onMessage(ConversationWithConstructor::class);

    $bot->getContainer()->addShared(CustomService::class, new CustomService());

    $bot->run();
    expect($bot->getData('test'))->toBe(1);

    $bot->run();
    expect($bot->getData('test'))->toBe(2);

    $bot->run();
    expect($bot->getData('test'))->toBe(1);
    \SergiX44\Nutgram\Conversations\Conversation::refreshOnDeserialize(false);
})->with('message');

it('works with explicit set of non serializable attributes', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(NonSerializableConversation::class);

    $bot->run();
    $bot->run();
    expect($bot->getData('test'))->toBe('ok');
})->with('message');
