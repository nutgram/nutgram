<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

class HookRemoveCommand extends Command
{
    protected $signature = 'nutgram:hook:remove {--d|drop-pending-updates}';

    protected $description = 'Remove the bot webhook';

    /**
     * @throws TelegramException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(): int
    {
        $dropPendingUpdates = $this->option('drop-pending-updates');

        /** @var Nutgram $bot */
        $bot = app(Nutgram::class);

        $bot->deleteWebhook([
            'drop_pending_updates' => $dropPendingUpdates,
        ]);

        if ($dropPendingUpdates) {
            $this->info('Pending updates dropped.');
        }
        $this->info('Bot webhook removed.');

        return 0;
    }
}
