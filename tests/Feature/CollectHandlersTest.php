<?php

use GuzzleHttp\Psr7\Response;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Attributes\UpdateTypes;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

it('calls middleware() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->middleware(function (Nutgram $bot, $next) {
        $bot->setData('called', true);
        $next($bot);
    });

    $bot->onText('Ciao', function (Nutgram $bot) {
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onCommand() handler', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->onCommand('test', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('command');

it('calls onText() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onText('Ciao', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onMessageType() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessageType(MessageTypes::TEXT, function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onMessageType() handler with invalid type', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessageType('foobar', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message')->throws(InvalidArgumentException::class, 'The parameter "type" is not a valid message type.');

it('calls onCallbackQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCallbackQuery(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('callback_query');

it('calls onCallbackQueryData() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCallbackQueryData('thedata', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('callback_query');

it('calls onEditedMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onEditedMessage(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('edited_message');

it('calls onChannelPost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChannelPost(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('channel_post');

it('calls onEditedChannelPost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onEditedChannelPost(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('edited_channel_post');

it('calls onInlineQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onInlineQuery(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('inline_query');

it('calls onChosenInlineResult() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChosenInlineResult(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('chosen_inline_result');

it('calls onShippingQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onShippingQuery(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('shipping_query');

it('calls onPreCheckoutQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPreCheckoutQuery(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('pre_checkout_query_payload');

it('calls onPreCheckoutQueryPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPreCheckoutQueryPayload('thedata', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('pre_checkout_query_payload');

it('calls onSuccessfulPayment() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPayment(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onSuccessfulPaymentPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onSuccessfulPaymentPayload('thedata', function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('successful_payment');

it('calls onPoll() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPoll(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('poll');

it('calls onPollAnswer() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPollAnswer(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('poll_answer');

it('calls onMyChatMember() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMyChatMember(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('my_chat_member');

it('calls onChatMember() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatMember(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('chat_member');

it('calls onChatJoinRequest() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatJoinRequest(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('chat_join_request');

it('calls onException() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onException() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(DivisionByZeroError::class, function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onApiError() handler', function ($update) {
    $bot = Nutgram::fake($update, [
        new Response(
            status: 400,
            body: '{"ok":false,"error_code":400,"description":"Bad Request: message is not modified"}'
        ),
    ]);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls onApiError() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update, [
        new Response(
            status: 400,
            body: '{"ok":false,"error_code":400,"description":"Bad Request: message is not modified"}'
        ),
    ]);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->sendMessage('test');
    });

    $bot->onApiError('.*not modified.*', function (Nutgram $bot, TelegramException $exception) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallback() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallback(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallbackOn() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallbackOn(UpdateTypes::MESSAGE, function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message');

it('calls fallbackOn() handler + pattern', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->fallbackOn('foo', '/test', function (Nutgram $bot) {
    });

    $bot->run();

    expect($bot->getData('called'))->toBeTrue();
})->with('message')->throws(InvalidArgumentException::class, 'The parameter "type" is not a valid update type.');

it('calls clearErrorHandlers() method', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $v = 1 / 0;
    });

    $bot->onException(function (Nutgram $bot) {
        $bot->setData('called', true);
    });

    $bot->clearErrorHandlers();

    $bot->run();

    expect($bot->getData('called'))->toBeNull();
})->with('message')->throws(DivisionByZeroError::class);
