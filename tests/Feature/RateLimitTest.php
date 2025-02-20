<?php

use SergiX44\Nutgram\Cache\Adapters\ArrayCache;
use SergiX44\Nutgram\Middleware\RateLimit;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Support\RateLimiter;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;

beforeEach(function () {
    $this->bot = Nutgram::fake();

    $this->bot->setCommonUser(User::make(
        id: 123456789,
        is_bot: false,
        first_name: 'Tony',
        last_name: 'Stark',
        username: 'IronMan',
        language_code: 'en',
    ));

    $this->bot->setCommonChat(Chat::make(
        id: 123456789,
        type: ChatType::PRIVATE,
        username: 'IronMan',
        first_name: 'Tony',
        last_name: 'Stark',
    ));
});

it('throttles a handler', function () {
    $this->bot->onText('hi', function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    })->throttle(2);

    ArrayCache::setTestNow(new DateTimeImmutable('2025-01-01 00:00:00'));
    RateLimiter::setTestNow(new DateTimeImmutable('2025-01-01 00:00:00'));

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('hi')->reply()->assertNoReply();

    ArrayCache::setTestNow(new DateTimeImmutable('2025-01-01 00:02:00'));
    RateLimiter::setTestNow(new DateTimeImmutable('2025-01-01 00:02:00'));

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
});

it('throttles with a custom warning message', function () {
    RateLimit::$warningCallback = function (Nutgram $bot, int $availableIn) {
        $bot->sendMessage("You're sending too many messages. Please wait $availableIn seconds.");
    };

    $this->bot->onText('hi', function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    })->throttle(2);

    ArrayCache::setTestNow(new DateTimeImmutable('2025-01-01 00:00:00'));
    RateLimiter::setTestNow(new DateTimeImmutable('2025-01-01 00:00:00'));

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');

    ArrayCache::setTestNow(new DateTimeImmutable('2025-01-01 00:00:10'));
    RateLimiter::setTestNow(new DateTimeImmutable('2025-01-01 00:00:10'));

    $this->bot->hearText('hi')->reply()->assertReplyText("You're sending too many messages. Please wait 50 seconds.");
});

todo('throttles a group');

todo('throttles globally');
