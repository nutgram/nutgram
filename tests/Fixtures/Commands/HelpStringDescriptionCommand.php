<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Commands;

use SergiX44\Nutgram\Handlers\Type\Command\Command;
use SergiX44\Nutgram\Nutgram;

class HelpStringDescriptionCommand implements Command
{
    public function description(): string|array
    {
        return 'Global description';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }
}
