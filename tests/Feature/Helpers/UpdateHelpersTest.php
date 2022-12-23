<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\User\User;

it('gets the User object using the getUser() method', function (object $update, string $handler, bool $exists) {
    $bot = Nutgram::fake($update);

    $bot->{$handler}(function (Nutgram $bot) use ($exists) {
        expect($bot->update()->getUser())
            ->when($exists, fn ($user) => $user->toBeInstanceOf(User::class))
            ->unless($exists, fn ($user) => $user->toBeNull());
    });

    $bot->run();
})->with('updates_user');

it('sets the User object using setUser() method', function (object $update, string $handler, bool $exists) {
    $bot = Nutgram::fake($update);

    $newUser = new User($bot);
    $newUser->id = 123456789;
    $newUser->is_bot = false;
    $newUser->username = 'supermario';
    $newUser->first_name = 'Mario';
    $newUser->last_name = 'Super';

    $bot->{$handler}(function (Nutgram $bot) use ($newUser, $exists) {
        expect($bot->update()->setUser($newUser))
            ->when($exists, fn ($user) => $user->toBeInstanceOf(User::class)->username->toBe('supermario'))
            ->unless($exists, fn ($user) => $user->toBeNull());
    });

    $bot->run();
})->with('updates_user');

it('gets the Chat object using the getChat() method', function (object $update, string $handler, bool $exists) {
    $bot = Nutgram::fake($update);

    $bot->{$handler}(function (Nutgram $bot) use ($exists) {
        expect($bot->update()->getChat())
            ->when($exists, fn ($chat) => $chat->toBeInstanceOf(Chat::class))
            ->unless($exists, fn ($chat) => $chat->toBeNull());
    });

    $bot->run();
})->with('updates_chat');

it('sets the Chat object using setChat() method', function (object $update, string $handler, bool $exists) {
    $bot = Nutgram::fake($update);

    $newChat = new Chat($bot);
    $newChat->id = 123456789;
    $newChat->type = 'private';
    $newChat->username = 'supermario';
    $newChat->first_name = 'Mario';
    $newChat->last_name = 'Super';

    $bot->{$handler}(function (Nutgram $bot) use ($newChat, $exists) {
        expect($bot->update()->setChat($newChat))
            ->when($exists, fn ($chat) => $chat->toBeInstanceOf(Chat::class)->username->toBe('supermario'))
            ->unless($exists, fn ($chat) => $chat->toBeNull());
    });

    $bot->run();
})->with('updates_chat');

it('gets the Message object using the getMessage() method', function (object $update, string $handler, bool $exists) {
    $bot = Nutgram::fake($update);

    $bot->{$handler}(function (Nutgram $bot) use ($exists) {
        expect($bot->update()->getMessage())
            ->when($exists, fn ($message) => $message->toBeInstanceOf(Message::class))
            ->unless($exists, fn ($message) => $message->toBeNull());
    });

    $bot->run();
})->with('updates_message');
