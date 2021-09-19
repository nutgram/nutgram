<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class HookRemoveCommand extends Command
{
    protected $signature = 'nutgram:hook:remove {--d|drop-pending-updates}';

    protected $description = 'Remove the bot webhook';

    public function handle(): int
    {
        $dropPendingUpdates = $this->option('drop-pending-updates');

        app(Nutgram::class)->deleteWebhook([
            'drop_pending_updates' => $dropPendingUpdates,
        ]);

        if ($dropPendingUpdates) {
            $this->info('Pending updates dropped.');
        }
        $this->info('Bot webhook removed.');

        return 0;
    }
}
