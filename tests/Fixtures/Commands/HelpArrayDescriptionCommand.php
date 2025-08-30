<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Commands;

use SergiX44\Nutgram\Handlers\Type\TelegramCommand;
use SergiX44\Nutgram\Nutgram;

class HelpArrayDescriptionCommand implements TelegramCommand
{
    public static string|array $description = [
        '*' => 'Global description',
        'es' => 'Español descripción',
        'it' => 'Descrizione italiana',
    ];

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }
}
