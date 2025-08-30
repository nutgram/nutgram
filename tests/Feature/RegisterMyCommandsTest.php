<?php

declare(strict_types=1);

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllChatAdministrators;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllGroupChats;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllPrivateChats;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChat;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatAdministrators;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatMember;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;
use SergiX44\Nutgram\Tests\Fixtures\Commands\HelpStringDescriptionCommand;

test('onCommand without description', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello World!');
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        $bot->setGlobalData('called', true);
        return $request;
    });

    $bot->registerMyCommands();

    expect($bot->getGlobalData('called', false))->toBeFalse();
});

test('onCommand with description', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello World!');
    })->description('Start command');

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request['json'])
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]');

        return $request;
    });

    $bot->registerMyCommands();
});

test('onCommand with WithDescription interface', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', HelpStringDescriptionCommand::class);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request['json'])
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"start","description":"Global description"}]');

        return $request;
    });

    $bot->registerMyCommands();
});

test('onCommand with description and scope', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello World!');
    })->description('Start command')->scope(new BotCommandScopeAllPrivateChats);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request['json'])
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]');

        return $request;
    });

    $bot->registerMyCommands();
});

test('onCommand with description and scopes (multiple calls)', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello World!');
    })->description('Start command')
        ->scope(new BotCommandScopeAllPrivateChats)
        ->scope(new BotCommandScopeAllGroupChats);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_group_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]'),
    );
});

test('onCommand with description and scopes (as array)', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello World!');
    })->description('Start command')
        ->scope([
            new BotCommandScopeAllPrivateChats,
            new BotCommandScopeAllGroupChats
        ]);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_group_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]'),
    );
});

test('multiple scopes', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Start command!');
    })
        ->description('Start command')
        ->scope(new BotCommandScopeAllPrivateChats)
        ->scope(new BotCommandScopeAllGroupChats);

    $bot->onCommand('help', function (Nutgram $bot) {
        $bot->sendMessage('Help command!');
    })
        ->description('Help command')
        ->scope(new BotCommandScopeAllPrivateChats);

    $bot->onCommand('about', function (Nutgram $bot) {
        $bot->sendMessage('About command!');
    })
        ->description('About command')
        ->scope(new BotCommandScopeAllGroupChats)
        ->scope(new BotCommandScopeAllChatAdministrators);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"help","description":"Help command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_group_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"about","description":"About command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_chat_administrators"}')
            ->commands->toBe('[{"command":"about","description":"About command"}]'),
    );
});

test('avoid duplicated scopes', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Start command!');
    })
        ->description('Start command')
        ->scope(new BotCommandScopeAllPrivateChats)
        ->scope(new BotCommandScopeAllGroupChats);

    $bot->onCommand('help', function (Nutgram $bot) {
        $bot->sendMessage('Help command!');
    })
        ->description('Help command')
        ->scope(new BotCommandScopeAllPrivateChats)
        ->scope(new BotCommandScopeAllPrivateChats);


    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"help","description":"Help command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_group_chats"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]'),
    );
});

test('all scopes', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Start command!');
    })
        ->description('Start command');

    $bot->onCommand('help', function (Nutgram $bot) {
        $bot->sendMessage('Help command!');
    })
        ->description('Help command')
        ->scope(new BotCommandScopeDefault);

    $bot->onCommand('admins', function (Nutgram $bot) {
        $bot->sendMessage('Admins command!');
    })
        ->description('Admins command')
        ->scope(new BotCommandScopeAllChatAdministrators);

    $bot->onCommand('groups', function (Nutgram $bot) {
        $bot->sendMessage('Groups command!');
    })
        ->description('Groups command')
        ->scope(new BotCommandScopeAllGroupChats);

    $bot->onCommand('private', function (Nutgram $bot) {
        $bot->sendMessage('Private command!');
    })
        ->description('Private command')
        ->scope(new BotCommandScopeAllPrivateChats);

    $bot->onCommand('chat_a', function (Nutgram $bot) {
        $bot->sendMessage('ChatA command!');
    })
        ->description('ChatA command')
        ->scope(new BotCommandScopeChat(123));

    $bot->onCommand('chat_b', function (Nutgram $bot) {
        $bot->sendMessage('ChatB command!');
    })
        ->description('ChatB command')
        ->scope(new BotCommandScopeChat(456));

    $bot->onCommand('chat_admin_a', function (Nutgram $bot) {
        $bot->sendMessage('ChatAdminA command!');
    })
        ->description('ChatAdminA command')
        ->scope(new BotCommandScopeChatAdministrators(123));

    $bot->onCommand('chat_admin_b', function (Nutgram $bot) {
        $bot->sendMessage('ChatAdminB command!');
    })
        ->description('ChatAdminB command')
        ->scope(new BotCommandScopeChatAdministrators(456));

    $bot->onCommand('chat_member_a', function (Nutgram $bot) {
        $bot->sendMessage('ChatMemberA command!');
    })
        ->description('ChatMemberA command')
        ->scope(new BotCommandScopeChatMember(123, 987));

    $bot->onCommand('chat_member_b', function (Nutgram $bot) {
        $bot->sendMessage('ChatMemberB command!');
    })
        ->description('ChatMemberB command')
        ->scope(new BotCommandScopeChatMember(123, 654));

    $bot->onCommand('chat_member_c', function (Nutgram $bot) {
        $bot->sendMessage('ChatMemberC command!');
    })
        ->description('ChatMemberC command')
        ->scope(new BotCommandScopeChatMember(456, 321))
        ->scope(new BotCommandScopeChatMember(123, 654));

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"help","description":"Help command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_chat_administrators"}')
            ->commands->toBe('[{"command":"admins","description":"Admins command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_group_chats"}')
            ->commands->toBe('[{"command":"groups","description":"Groups command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_private_chats"}')
            ->commands->toBe('[{"command":"private","description":"Private command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat","chat_id":123}')
            ->commands->toBe('[{"command":"chat_a","description":"ChatA command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat","chat_id":456}')
            ->commands->toBe('[{"command":"chat_b","description":"ChatB command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat_administrators","chat_id":123}')
            ->commands->toBe('[{"command":"chat_admin_a","description":"ChatAdminA command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat_administrators","chat_id":456}')
            ->commands->toBe('[{"command":"chat_admin_b","description":"ChatAdminB command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat_member","chat_id":123,"user_id":987}')
            ->commands->toBe('[{"command":"chat_member_a","description":"ChatMemberA command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat_member","chat_id":123,"user_id":654}')
            ->commands->toBe('[{"command":"chat_member_b","description":"ChatMemberB command"},{"command":"chat_member_c","description":"ChatMemberC command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"chat_member","chat_id":456,"user_id":321}')
            ->commands->toBe('[{"command":"chat_member_c","description":"ChatMemberC command"}]'),
    );
});

test('grouped scopes with nesting level 1', function ($update) {
    $bot = Nutgram::fake($update);

    $history = [];

    $bot->group(function (Nutgram $bot) use (&$test) {
        $bot->onCommand('start', function (Nutgram $bot) {
        })
            ->description('Start command')
            ->scope(new BotCommandScopeDefault);

        $bot->onCommand('admin', function (Nutgram $bot) {
        })
            ->description('Admin command');
    })->scope(new BotCommandScopeAllChatAdministrators);

    $bot->onCommand('about', function (Nutgram $bot) {
    })
        ->description('About command');

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"about","description":"About command"},{"command":"start","description":"Start command"}]'),
        fn ($x) => $x
            ->scope->toBe('{"type":"all_chat_administrators"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"admin","description":"Admin command"}]'),
    );
})->with('message');

test('onCommand with optional parameter + description', function () {
    $bot = Nutgram::fake();

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Hello!');
    })->description('Start command');

    $bot->onCommand('start {value}', function (Nutgram $bot, string $value) {
        $bot->sendMessage("Hello $value!");
    })->description('Start command');

    $bot->onCommand('foo', function (Nutgram $bot) {
        $bot->sendMessage('foo');
    })->description('foo command');

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request['json'])
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"start","description":"Start command"},{"command":"foo","description":"foo command"}]');

        return $request;
    });

    $bot->registerMyCommands();
});

test('register commands with multiple scopes + languages', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Start command!');
    })
        ->description([
            'en' => 'Start command',
            'it' => 'Comando start'
        ])
        ->scope(new BotCommandScopeAllPrivateChats)
        ->scope(new BotCommandScopeAllGroupChats);

    $bot->onCommand('help', function (Nutgram $bot) {
        $bot->sendMessage('Help command!');
    })
        ->description([
            'it' => 'Comando help',
            '*' => 'Help command'
        ])
        ->scope(new BotCommandScopeAllPrivateChats);

    $bot->onCommand('about', function (Nutgram $bot) {
        $bot->sendMessage('About command!');
    })
        ->description('About command')
        ->scope(new BotCommandScopeAllGroupChats)
        ->scope(new BotCommandScopeAllChatAdministrators);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Start command"}]')
            ->scope->toBe('{"type":"all_private_chats"}')
            ->language_code->toBe('en'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Comando start"},{"command":"help","description":"Comando help"}]')
            ->scope->toBe('{"type":"all_private_chats"}')
            ->language_code->toBe('it'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"help","description":"Help command"}]')
            ->scope->toBe('{"type":"all_private_chats"}'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Start command"}]')
            ->scope->toBe('{"type":"all_group_chats"}')
            ->language_code->toBe('en'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Comando start"}]')
            ->scope->toBe('{"type":"all_group_chats"}')
            ->language_code->toBe('it'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"about","description":"About command"}]')
            ->scope->toBe('{"type":"all_group_chats"}'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"about","description":"About command"}]')
            ->scope->toBe('{"type":"all_chat_administrators"}'),
    );
});

test('register commands with languages', function () {
    $bot = Nutgram::fake();

    $history = [];

    $bot->onCommand('start', function (Nutgram $bot) {
        $bot->sendMessage('Start command!');
    })
        ->description([
            'en' => 'Start command',
            'it' => 'Comando start'
        ]);

    $bot->onCommand('help', function (Nutgram $bot) {
        $bot->sendMessage('Help command!');
    })
        ->description([
            'it' => 'Comando help',
            '*' => 'Help command'
        ]);

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) use (&$history) {
        $history[] = $request['json'];

        return $request;
    });

    $bot->registerMyCommands();

    expect($history)->sequence(
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Start command"}]')
            ->scope->toBe('{"type":"default"}')
            ->language_code->toBe('en'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"start","description":"Comando start"},{"command":"help","description":"Comando help"}]')
            ->scope->toBe('{"type":"default"}')
            ->language_code->toBe('it'),
        fn ($x) => $x
            ->commands->toBe('[{"command":"help","description":"Help command"}]')
            ->scope->toBe('{"type":"default"}'),
    );
});
