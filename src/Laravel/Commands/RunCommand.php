<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Nutgram;

class RunCommand extends Command
{
    protected $signature = 'nutgram:run';

    protected $description = 'Start the bot in long polling mode';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Nutgram $bot): void
    {
        $bot->run();
    }
}
