<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatJoinRequest;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberUpdated;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Inline\CallbackQuery;
use SergiX44\Nutgram\Telegram\Types\Inline\ChosenInlineResult;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQuery;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Payment\PreCheckoutQuery;
use SergiX44\Nutgram\Telegram\Types\Payment\ShippingQuery;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Poll\PollAnswer;
use SergiX44\Nutgram\Telegram\Types\User\User;

test('update() returns Update object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->update())->toBeInstanceOf(Update::class);
    expect($bot->update()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('message');

test('chat() returns Chat object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->chat())->toBeInstanceOf(Chat::class);
    expect($bot->chat()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('message');

test('user() returns User object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->user())->toBeInstanceOf(User::class);
    expect($bot->user()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('message');

test('messageId() returns message id', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->messageId())->toBe(123);
})->with('message');

test('message() returns Message object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->message())->toBeInstanceOf(Message::class);
    expect($bot->message()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('message');

test('isCallbackQuery() returns boolean', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isCallbackQuery())->toBeTrue();
})->with('callback_query');

test('callbackQuery() returns CallbackQuery object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->callbackQuery())->toBeInstanceOf(CallbackQuery::class);
    expect($bot->callbackQuery()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('callback_query');

test('isInlineQuery() returns boolean', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isInlineQuery())->toBeTrue();
})->with('inline_query');

test('inlineQuery() returns InlineQuery object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->inlineQuery())->toBeInstanceOf(InlineQuery::class);
    expect($bot->inlineQuery()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('inline_query');

test('chosenInlineResult() returns ChosenInlineResult object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->chosenInlineResult())->toBeInstanceOf(ChosenInlineResult::class);
    expect($bot->chosenInlineResult()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('chosen_inline_result');

test('shippingQuery() returns ShippingQuery object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->shippingQuery())->toBeInstanceOf(ShippingQuery::class);
    expect($bot->shippingQuery()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('shipping_query');

test('isPreCheckoutQuery() returns boolean', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isPreCheckoutQuery())->toBeTrue();
})->with('pre_checkout_query');

test('preCheckoutQuery() returns PreCheckoutQuery object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->preCheckoutQuery())->toBeInstanceOf(PreCheckoutQuery::class);
    expect($bot->preCheckoutQuery()->getBot())->toBeInstanceOf(Nutgram::class);
    expect($bot->preCheckoutQuery()->from->getBot())->toBeInstanceOf(Nutgram::class);
})->with('pre_checkout_query');

test('poll() returns Poll object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->poll())->toBeInstanceOf(Poll::class);
    expect($bot->poll()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('poll');

test('pollAnswer() returns PollAnswer object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->pollAnswer())->toBeInstanceOf(PollAnswer::class);
    expect($bot->pollAnswer()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('poll_answer');

test('isMyChatMember() returns boolean', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isMyChatMember())->toBeTrue();
})->with('my_chat_member');

test('chatMember() returns ChatMember object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->chatMember())->toBeInstanceOf(ChatMemberUpdated::class);
    expect($bot->chatMember()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('my_chat_member');

test('chatJoinRequest() returns ChatJoinRequest object', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->chatJoinRequest())->toBeInstanceOf(ChatJoinRequest::class);
    expect($bot->chatJoinRequest()->getBot())->toBeInstanceOf(Nutgram::class);
})->with('chat_join_request');

test('inlineMessageId() returns inline message id', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->inlineMessageId())->toBe('123');
})->with('chosen_inline_result');

test('isCommand() returns true on command input', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isCommand())->toBeTrue();
})->with('command');

test('isCommand() returns false on command inside a text', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isCommand())->toBeFalse();
})->with('not_command');

test('isCommand() returns false on text', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->run();

    expect($bot->isCommand())->toBeFalse();
})->with('text');
