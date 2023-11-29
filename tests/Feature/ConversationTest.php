<?php

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Fake;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationEmpty;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithBeforeStep;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithClosing;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithClosingMultipleSteps;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithConstructor;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithDefault;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithMissingStep;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithSkipHandlersMultipleSteps;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\ConversationWithSkipMiddlewareMultipleSteps;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\NonSerializableConversation;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\OneStepNotCompletedConversation;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\SurveyConversation;
use SergiX44\Nutgram\Tests\Fixtures\Conversations\TwoStepConversation;
use SergiX44\Nutgram\Tests\Fixtures\CustomService;

it('calls the conversation steps', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(TwoStepConversation::class);
    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->run();
    expect($bot->get('test'))->toBe(2);

    $bot->run();
    expect($bot->get('test'))->toBe(1);
})->with('message');

it('calls the default conversation step', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithDefault::class);
    $bot->run();

    expect($bot->get('test'))->toBe(1);
})->with('message');

it('starts from an handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(function (Nutgram $bot) {
        ConversationWithDefault::begin($bot);
    });
    $bot->run();

    expect($bot->get('test'))->toBe(1);
})->with('message');

it('calls the closing handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosing::class);
    $bot->run();

    expect($bot->get('test'))->toBe(2);
})->with('message');

it('calls the before step handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithBeforeStep::class);
    $bot->run();

    expect($bot->get('test'))->toBe(2);
})->with('message');

it('calls the closing handler with multiple steps', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosingMultipleSteps::class);

    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->run();
    expect($bot->get('test'))->toBe(3);
})->with('message');

it('it escapes the conversation when a specific handler is matched', function ($update, $command) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithClosingMultipleSteps::class);
    $bot->onCommand('start', function ($bot) {
        $bot->set('test', -1);
    });

    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->setRunningMode(new Fake($command));
    $bot->run();
    expect($bot->get('test'))->toBe(-1);
})->with('message_and_command');

it('it skips the middleware on the conversation when specified', function ($update, $command) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(ConversationWithSkipMiddlewareMultipleSteps::class);
    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->set('test', $bot->get('test', 0) + 1);
        $next($bot);
    });

    $bot->run();
    expect($bot->get('test'))->toBe(2);

    $bot->setRunningMode(new Fake($command));
    $bot->run();
    expect($bot->get('test'))->toBe(3);
})->with('message_and_command');

it(
    'it not escapes the conversation when a specific handler is matched because it skips handler',
    function ($update, $command) {
        $bot = Nutgram::fake($update);
        $bot->onMessage(ConversationWithSkipHandlersMultipleSteps::class);
        $bot->onCommand('start', function ($bot) {
            $bot->set('test', -1);
        });

        $bot->run();
        expect($bot->get('test'))->toBe(1);

        $bot->setRunningMode(new Fake($command));
        $bot->run();
        expect($bot->get('test'))->toBe(2);
    }
)->with('message_and_command');

it('calls the same handler if not end or next step called', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(OneStepNotCompletedConversation::class);
    $bot->run();
    $bot->run();
    $bot->run();

    expect($bot->get('test'))->toBe(4);
})->with('message');

it('calls the conversation steps without class', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage('firstStep');

    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->run();
    expect($bot->get('test'))->toBe(2);

    $bot->run();
    expect($bot->get('test'))->toBe(1);
})->with('message');

function firstStep(Nutgram $bot)
{
    $bot->set('test', 1);
    $bot->stepConversation('secondStep');
}

function secondStep(Nutgram $bot)
{
    $bot->set('test', 2);
    $bot->endConversation();
}

it('works with inline conversations', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->set('test', 1);

        $bot->stepConversation(function (Nutgram $bot) {
            $bot->set('test', 2);
            $bot->endConversation();
        });
    });

    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->run();
    expect($bot->get('test'))->toBe(2);

    $bot->run();
    expect($bot->get('test'))->toBe(1);
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
})->with('message')->throws(RuntimeException::class, "Conversation step 'start' not found.");

it('does not work with missing step', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(ConversationWithMissingStep::class);

    $bot->run();
})->with('message')->throws(RuntimeException::class, "Conversation step 'missing' not found.");

it('calls the conversation constructor at every step', function ($update) {
    $bot = Nutgram::fake($update);
    Conversation::refreshOnDeserialize();
    $bot->onMessage(ConversationWithConstructor::class);

    $bot->getContainer()->set(CustomService::class, new CustomService());

    $bot->run();
    expect($bot->get('test'))->toBe(1);

    $bot->run();
    expect($bot->get('test'))->toBe(2);

    $bot->run();
    expect($bot->get('test'))->toBe(1);
    Conversation::refreshOnDeserialize(false);
})->with('message');

it('works with explicit set of non serializable attributes', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onMessage(NonSerializableConversation::class);

    $bot->run();
    $bot->run();
    expect($bot->get('test'))->toBe('ok');
})->with('message');

it('starts manually for a specific user/chat', function () {
    $userId = 123;
    $chatId = 456;

    $bot = Nutgram::fake();

    TwoStepConversation::begin($bot, $userId, $chatId);

    $bot->assertActiveConversation($userId, $chatId);

    expect($bot->get('test'))->toBe(1);
});

it('fails to start manually for a specific user/chat', function () {
    $bot = Nutgram::fake();
    TwoStepConversation::begin($bot, 123, null);
})->throws(InvalidArgumentException::class, 'You need to provide both userId and chatId.');

it('starts manually with additional data', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('survey-66', function (Nutgram $bot) {
        SurveyConversation::begin($bot, data: [
            'surveyID' => 66,
        ]);
    });

    $bot
        ->willStartConversation()
        ->hearText('/survey-66')
        ->reply()
        ->assertActiveConversation()
        ->hearText('wow')
        ->reply()
        ->assertNoConversation();

    expect($bot->get('test'))->toBe(66);
});
