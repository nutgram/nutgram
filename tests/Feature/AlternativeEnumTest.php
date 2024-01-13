<?php

use SergiX44\Nutgram\Nutgram;

it('calls onDice() handler with a non mapped value', function ($update) {
    $update->message->dice->emoji = 'XXX';

    $bot = Nutgram::fake($update);
    $bot->onDice(function (Nutgram $bot) {
        $bot->set('called', true);
        expect($bot->message()->dice->emoji)->toBe('XXX');
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('dice');

it('calls onChatBoost() handler with a non mapped type', function ($update) {
    $update->chat_boost->boost->source->source = 'god';
    $update->chat_boost->boost->source->name = 'jesus';


    $bot = Nutgram::fake($update);

    $bot->onChatBoost(function (Nutgram $bot) {
        $bot->set('called', true);
        $boost = $bot->chatBoost();
        expect($boost->boost->source->source)->toBe('god')
            ->and($boost->boost->source->name)->toBe('jesus')
            ->and((new ReflectionClass($boost->boost->source))->isAnonymous())->toBeTrue();
        ;
    });

    $bot->run();

    expect($bot->get('called'))->toBeTrue();
})->with('chat_boost');
