<?php

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Tests\Fixtures\Cache\TestCache;

it('throttles a handler', function () {
    $bot = Nutgram::fake(config: new Configuration(
        cache: new TestCache(),
    ));

    $bot->setCommonUser(User::make(
        id: 123456789,
        is_bot: false,
        first_name: 'Tony',
        last_name: 'Stark',
        username: 'IronMan',
        language_code: 'en',
    ));

    $bot->setCommonChat(Chat::make(
        id: 123456789,
        type: ChatType::PRIVATE,
        username: 'IronMan',
        first_name: 'Tony',
        last_name: 'Stark',
    ));

    //TODO: $bot->throttle(10);

    $bot->onText('hi', function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    })->throttle(2);

    TestCache::setTestNow(new DateTimeImmutable('+1 seconds'));

    $bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $bot->hearText('hi')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $bot->hearText('hi')->reply()->assertNoReply();

    TestCache::setTestNow(new DateTimeImmutable('+61 seconds'));

    $bot->hearText('hi')->reply()->assertReplyText('Hello!');
});

todo('throttles a group');

todo('throttles globally');
