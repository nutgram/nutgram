<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Commands;

use SergiX44\Nutgram\Handlers\Type\TelegramCommand;
use SergiX44\Nutgram\Nutgram;

class HelpStringDescriptionCommand implements TelegramCommand
{
    public string|array $description = 'Global description';

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }
}
