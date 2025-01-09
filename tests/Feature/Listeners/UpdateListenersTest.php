<?php

declare(strict_types=1);

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostRemoved;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostUpdated;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessConnection;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessMessagesDeleted;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginUser;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionCountUpdated;
use SergiX44\Nutgram\Telegram\Types\Reaction\MessageReactionUpdated;

it('calls onUpdate() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onUpdate(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->updateId())->toBe(1);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('channel_post');

it('calls onMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->messageThreadId())->toBe(33);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_topic');

it('calls onMessage() handler with forward', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessage(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->message()->forward_origin)
            ->toBeInstanceOf(MessageOriginUser::class)
            ->and($bot->message()->forward_origin->sender_user->id)
            ->toBe(429000);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_forward_origin');

it('calls onMessageType() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessageType(MessageType::TEXT, function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message');

it('calls onEditedMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onEditedMessage(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('edited_message');

it('calls onChannelPost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChannelPost(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('channel_post');

it('calls onEditedChannelPost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onEditedChannelPost(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('edited_channel_post');

it('calls onBusinessConnection() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onBusinessConnection(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->businessConnection())->toBeInstanceOf(BusinessConnection::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('business_connection');

it('calls onBusinessMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onBusinessMessage(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('business_message');

it('calls onEditedBusinessMessage() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onEditedBusinessMessage(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('edited_business_message');

it('calls onDeletedBusinessMessages() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onDeletedBusinessMessages(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->deletedBusinessMessages())->toBeInstanceOf(BusinessMessagesDeleted::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('deleted_business_messages');

it('calls onMessageReaction() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessageReaction(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->messageReaction())->toBeInstanceOf(MessageReactionUpdated::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_reaction');

it('calls onMessageReactionCount() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMessageReactionCount(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->messageReactionCount())->toBeInstanceOf(MessageReactionCountUpdated::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('message_reaction_count');

it('calls onInlineQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onInlineQuery(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('inline_query');

it('calls onInlineQueryText() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onInlineQueryText('test', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('inline_query');

it('calls onChosenInlineResult() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChosenInlineResult(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chosen_inline_result');

it('calls onChosenInlineResultData() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChosenInlineResultQuery('test', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chosen_inline_result');

it('calls onCallbackQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCallbackQuery(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->message()->isInaccessible())->toBeFalse();
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('callback_query');

it('calls onCallbackQueryData() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCallbackQueryData('thedata', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('callback_query');

it('calls onCallbackQuery() handler with inaccessible message', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onCallbackQuery(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->message()->isInaccessible())->toBeTrue();
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('callback_query_inaccessible_message');

it('calls onShippingQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onShippingQuery(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('shipping_query');

it('calls onPreCheckoutQuery() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPreCheckoutQuery(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('pre_checkout_query');

it('calls onPreCheckoutQueryPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPreCheckoutQueryPayload('thedata', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('pre_checkout_query');

it('calls onPaidMediaPurchased() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPaidMediaPurchased(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called', false))->toBeTrue();
})->with('paid_media_purchased');

it('calls onPaidMediaPurchasedPayload() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPaidMediaPurchasedPayload('wow', function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called', false))->toBeTrue();
})->with('paid_media_purchased');

it('calls onUpdatePoll() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onUpdatePoll(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('poll');

it('calls onPollAnswer() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onPollAnswer(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('poll_answer');

it('calls onMyChatMember() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onMyChatMember(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('my_chat_member');

it('calls onChatMember() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatMember(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chat_member');

it('calls onChatJoinRequest() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatJoinRequest(function (Nutgram $bot) {
        $bot->set('called', true);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chat_join_request');

it('calls onChatBoost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onChatBoost(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->chatBoost())->toBeInstanceOf(ChatBoostUpdated::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chat_boost');

it('calls onRemovedChatBoost() handler', function ($update) {
    $bot = Nutgram::fake($update);

    $bot->onRemovedChatBoost(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->removedChatBoost())->toBeInstanceOf(ChatBoostRemoved::class);
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('removed_chat_boost');
