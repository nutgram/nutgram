<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class HookSetCommand extends Command
{
    protected $signature = 'nutgram:hook:set {url} {--ip=}';

    protected $description = 'Set the bot webhook';

    public function handle(): int
    {
        $url = $this->argument('url');
        $ip = $this->argument('ip');

        app(Nutgram::class)->setWebhook($url, array_filter(compact('ip')));

        $this->info("Bot webhook set with url: $url");

        return 0;
    }
}
