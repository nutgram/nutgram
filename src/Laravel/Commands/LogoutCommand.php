<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

class LogoutCommand extends Command
{
    protected $signature = 'nutgram:logout {--d|drop-pending-updates}';

    protected $description = 'Log out from the cloud Bot API server';

    /**
     * @throws TelegramException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(Nutgram $bot): int
    {
        $dropPendingUpdates = (bool)$this->option('drop-pending-updates');

        try {
            $bot->deleteWebhook(['drop_pending_updates' => $dropPendingUpdates]);
        } finally {
            $this->info('Webhook deleted.');
        }

        try {
            $bot->close();
        } finally {
            $this->info('Bot closed.');
        }

        try {
            $bot->logOut();
        } finally {
            $this->info('Logged out.');
        }

        $this->newLine();
        $this->info('Done.');
        $this->warn('Remember to set the webhook again if needed!');

        return 0;
    }
}
