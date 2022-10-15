<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

class HookSetCommand extends Command
{
    protected $signature = 'nutgram:hook:set {url} {--ip=} {--max-connections=50}';

    protected $description = 'Set the bot webhook';

    /**
     * @throws TelegramException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(): int
    {
        /** @var string $url */
        $url = $this->argument('url');

        /** @var ?string $ip_address */
        $ip_address = $this->option('ip') ?: null;

        /** @var ?string $max_connections */
        $max_connections = $this->option('max-connections') ?: null;

        //cast to int if not null
        if (is_numeric($max_connections)) {
            $max_connections = (int)$max_connections;
        }

        /** @var Nutgram $bot */
        $bot = app(Nutgram::class);

        $bot->setWebhook($url, array_filter(compact('ip_address', 'max_connections')));

        $this->info("Bot webhook set with url: $url");

        return 0;
    }
}
