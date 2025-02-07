<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Tests\Fixtures\Commands;

use SergiX44\Nutgram\Handlers\Type\WithDescription;
use SergiX44\Nutgram\Nutgram;

class HelpArrayDescriptionCommand implements WithDescription
{
    public static function description(): string|array
    {
        return [
            '*' => 'Global description',
            'es' => 'Español descripción',
            'it' => 'Descrizione italiana',
        ];
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('hello');
    }
}
