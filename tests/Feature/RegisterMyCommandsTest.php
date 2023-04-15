<?php

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllChatAdministrators;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllGroupChats;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllPrivateChats;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChat;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatAdministrators;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeChatMember;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

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

test('registerCommand without description', function () {
    $bot = Nutgram::fake();

    $bot->registerCommand(new class extends Command {
        protected string $command = 'start';

        public function handle(Nutgram $bot): void
        {
            $bot->sendMessage('Hello World!');
        }
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

test('registerCommand with description', function () {
    $bot = Nutgram::fake();

    $bot->registerCommand(new class extends Command {
        protected string $command = 'start';
        protected ?string $description = 'Start command';

        public function handle(Nutgram $bot): void
        {
            $bot->sendMessage('Hello World!');
        }
    });

    $bot->beforeApiRequest(function (Nutgram $bot, array $request) {
        expect($request['json'])
            ->scope->toBe('{"type":"default"}')
            ->commands->toBe('[{"command":"start","description":"Start command"}]');

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

test('registerCommand with description and scope', function () {
    $bot = Nutgram::fake();

    $bot->registerCommand(new class extends Command {
        protected string $command = 'start';
        protected ?string $description = 'Start command';

        public function scopes(): array
        {
            return [
                new BotCommandScopeAllPrivateChats,
            ];
        }

        public function handle(Nutgram $bot): void
        {
            $bot->sendMessage('Hello World!');
        }
    });

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

test('grouped scopes', function () {
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
