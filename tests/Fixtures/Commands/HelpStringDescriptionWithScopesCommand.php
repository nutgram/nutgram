<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Commands;

use SergiX44\Nutgram\Handlers\Type\TelegramCommand;
use SergiX44\Nutgram\Handlers\Type\WithScopes;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllPrivateChats;

class HelpStringDescriptionWithScopesCommand implements TelegramCommand, WithScopes
{
    public function description(): string|array
    {
        return 'Description with scopes';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }

    public function scopes(): array
    {
        return [
            new BotCommandScopeAllPrivateChats,
        ];
    }
}
