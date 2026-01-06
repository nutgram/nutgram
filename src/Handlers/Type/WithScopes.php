<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Handlers\Type;

use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

interface WithScopes
{
    /**
     * Here you can define the scopes of the command.
     * @return BotCommandScope[]
     * @see https://nutgram.dev/docs/usage/handlers#scope-support
     */
    public function scopes(): array;
}
