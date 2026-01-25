<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Testing\TestClock;

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

    TestClock::freeze();

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('hi')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
});

it('throttles with a custom warning message', function () {
    $warningCallback = function (Nutgram $bot, int $availableIn) {
        $bot->sendMessage("You're sending too many messages. Please wait $availableIn seconds.");
    };

    $this->bot->onText('hi', function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    })->throttle(2, warningCallback: $warningCallback);

    TestClock::freeze();

    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');
    $this->bot->hearText('hi')->reply()->assertReplyText('Hello!');

    TestClock::sleep(10);

    $this->bot->hearText('hi')->reply()->assertReplyText("You're sending too many messages. Please wait 50 seconds.");
});

it('throttles a group', function () {
    $this->bot->group(function (Nutgram $bot) {
        $bot->onText('hello', function (Nutgram $bot) {
            $bot->sendMessage('world');
        });

        $bot->onText('foo', function (Nutgram $bot) {
            $bot->sendMessage('bar');
        });
    })->throttle(2);

    TestClock::freeze();

    $this->bot->hearText('hello')->reply()->assertReplyText('world');
    $this->bot->hearText('foo')->reply()->assertReplyText('bar');
    $this->bot->hearText('hello')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('hello')->reply()->assertNoReply();
    $this->bot->hearText('foo')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('hello')->reply()->assertReplyText('world');
    $this->bot->hearText('foo')->reply()->assertReplyText('bar');
});

it('throttles globally', function () {
    $this->bot->throttle(2);

    $this->bot->onText('hello', function (Nutgram $bot) {
        $bot->sendMessage('world');
    });

    $this->bot->onText('foo', function (Nutgram $bot) {
        $bot->sendMessage('bar');
    });

    TestClock::freeze();

    $this->bot->hearText('hello')->reply()->assertReplyText('world');
    $this->bot->hearText('foo')->reply()->assertReplyText('bar');
    $this->bot->hearText('foo')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('foo')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('hello')->reply()->assertReplyText('world');
    $this->bot->hearText('foo')->reply()->assertReplyText('bar');
});

it('throttles hard', function () {
    $this->bot->throttle(4);

    $this->bot->onText('root_no', function (Nutgram $bot) {
        $bot->sendMessage('This is the root_no command');
    });

    $this->bot->onText('root_yes', function (Nutgram $bot) {
        $bot->sendMessage('This is the root_yes command');
    })->throttle(2);

    $this->bot->group(function (Nutgram $bot) {
        $bot->onText('group_no', function (Nutgram $bot) {
            $bot->sendMessage('This is the group_no command');
        });

        $bot->onText('group_yes_lower', function (Nutgram $bot) {
            $bot->sendMessage('This is the group_yes_lower command');
        })->throttle(2);

        $bot->onText('group_yes_higher', function (Nutgram $bot) {
            $bot->sendMessage('This is the group_yes_higher command');
        })->throttle(5);

        $bot->group(function (Nutgram $bot) {
            $bot->onText('nested_group_no', function (Nutgram $bot) {
                $bot->sendMessage('This is the nested_group_no command');
            });

            $bot->onText('nested_group_yes_lower', function (Nutgram $bot) {
                $bot->sendMessage('This is the nested_group_yes_lower command');
            })->throttle(1);

            $bot->onText('nested_group_yes_higher', function (Nutgram $bot) {
                $bot->sendMessage('This is the nested_group_yes_higher command');
            })->throttle(3);
        })->throttle(2);
    })->throttle(3);

    TestClock::freeze();

    $this->bot->hearText('root_no')->reply()->assertReplyText('This is the root_no command');
    $this->bot->hearText('root_no')->reply()->assertReplyText('This is the root_no command');
    $this->bot->hearText('root_no')->reply()->assertReplyText('This is the root_no command');
    $this->bot->hearText('root_no')->reply()->assertReplyText('This is the root_no command');
    $this->bot->hearText('root_no')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('root_no')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('root_no')->reply()->assertReplyText('This is the root_no command');

    // =======================================================

    $this->bot->hearText('root_yes')->reply()->assertReplyText('This is the root_yes command');
    $this->bot->hearText('root_yes')->reply()->assertReplyText('This is the root_yes command');
    $this->bot->hearText('root_yes')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('root_yes')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('root_yes')->reply()->assertReplyText('This is the root_yes command');

    // =======================================================

    $this->bot->hearText('group_no')->reply()->assertReplyText('This is the group_no command');
    $this->bot->hearText('group_no')->reply()->assertReplyText('This is the group_no command');
    $this->bot->hearText('group_no')->reply()->assertReplyText('This is the group_no command');
    $this->bot->hearText('group_no')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('group_no')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('group_no')->reply()->assertReplyText('This is the group_no command');

    // =======================================================

    $this->bot->hearText('group_yes_lower')->reply()->assertReplyText('This is the group_yes_lower command');
    $this->bot->hearText('group_yes_lower')->reply()->assertReplyText('This is the group_yes_lower command');
    $this->bot->hearText('group_yes_lower')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('group_yes_lower')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('group_yes_lower')->reply()->assertReplyText('This is the group_yes_lower command');

    // =======================================================

    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');
    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');
    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');
    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');
    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');
    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('group_yes_higher')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('group_yes_higher')->reply()->assertReplyText('This is the group_yes_higher command');

    // =======================================================

    $this->bot->hearText('nested_group_no')->reply()->assertReplyText('This is the nested_group_no command');
    $this->bot->hearText('nested_group_no')->reply()->assertReplyText('This is the nested_group_no command');
    $this->bot->hearText('nested_group_no')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('nested_group_no')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('nested_group_no')->reply()->assertReplyText('This is the nested_group_no command');

    // =======================================================

    $this->bot->hearText('nested_group_yes_lower')->reply()->assertReplyText('This is the nested_group_yes_lower command');
    $this->bot->hearText('nested_group_yes_lower')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('nested_group_yes_lower')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('nested_group_yes_lower')->reply()->assertReplyText('This is the nested_group_yes_lower command');

    // =======================================================

    $this->bot->hearText('nested_group_yes_higher')->reply()->assertReplyText('This is the nested_group_yes_higher command');
    $this->bot->hearText('nested_group_yes_higher')->reply()->assertReplyText('This is the nested_group_yes_higher command');
    $this->bot->hearText('nested_group_yes_higher')->reply()->assertReplyText('This is the nested_group_yes_higher command');
    $this->bot->hearText('nested_group_yes_higher')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('nested_group_yes_higher')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('nested_group_yes_higher')->reply()->assertReplyText('This is the nested_group_yes_higher command');
});

it('does not throttle if the user or chat is not set', function ($update) {
    $bot = Nutgram::fake($update);
    $bot->throttle(1);

    $bot->onDeletedBusinessMessages(function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    });

    $bot->run();
    $bot->assertReplyText('Hello!');

    $bot->run();
    $bot->assertReplyText('Hello!');
})->with('deleted_business_messages');

it('does not throttle with withoutThrottle method', function () {
    $this->bot->throttle(1);

    $this->bot->onText('yes', function (Nutgram $bot) {
        $bot->sendMessage('yes');
    });

    $this->bot->onText('no', function (Nutgram $bot) {
        $bot->sendMessage('no');
    })->withoutThrottle();

    $this->bot->group(function (Nutgram $bot) {
        $bot->onText('maybe', function (Nutgram $bot) {
            $bot->sendMessage('maybe');
        });

        $bot->onText('lol', function (Nutgram $bot) {
            $bot->sendMessage('lol');
        })->throttle(1);
    })->withoutThrottle();

    TestClock::freeze();

    $this->bot->hearText('yes')->reply()->assertReplyText('yes');
    $this->bot->hearText('yes')->reply()->assertReplyText('Too many messages, please wait a bit. This message will only be sent once until the rate limit is reset.');
    $this->bot->hearText('yes')->reply()->assertNoReply();

    TestClock::sleep(60);

    $this->bot->hearText('yes')->reply()->assertReplyText('yes');

    $this->bot->hearText('no')->reply()->assertReplyText('no');
    $this->bot->hearText('no')->reply()->assertReplyText('no');
    $this->bot->hearText('no')->reply()->assertReplyText('no');

    $this->bot->hearText('maybe')->reply()->assertReplyText('maybe');
    $this->bot->hearText('maybe')->reply()->assertReplyText('maybe');
    $this->bot->hearText('maybe')->reply()->assertReplyText('maybe');

    $this->bot->hearText('lol')->reply()->assertReplyText('lol');
    $this->bot->hearText('lol')->reply()->assertReplyText('lol');
    $this->bot->hearText('lol')->reply()->assertReplyText('lol');
});
