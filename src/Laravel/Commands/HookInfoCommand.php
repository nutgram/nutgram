<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class HookInfoCommand extends Command
{
    protected $signature = 'nutgram:hook:info';

    protected $description = 'Get current webhook status';

    public function handle(): int
    {
        $info = app(Nutgram::class)->getWebhookInfo();

        $lastErrorDate = null;
        if ($info->last_error_date !== null) {
            $lastErrorDate = date('Y-m-d H:i:s', $info->last_error_date).' UTC';
        }

        $lastSynchronizationErrorDate = null;
        if ($info->last_synchronization_error_date !== null) {
            $lastSynchronizationErrorDate = date('Y-m-d H:i:s', $info->last_synchronization_error_date).' UTC';
        }

        $this->table(['Info', 'Value'], [
            ['url', $info->url],
            ['has_custom_certificate', $info->has_custom_certificate ? 'true' : 'false'],
            ['pending_update_count', $info->pending_update_count],
            ['ip_address', $info->ip_address],
            ['last_error_date', $lastErrorDate],
            ['last_error_message', $info->last_error_message],
            ['last_synchronization_error_date', $lastSynchronizationErrorDate],
            ['max_connections', $info->max_connections],
            ['allowed_updates', implode(', ', $info->allowed_updates ?: [])],
        ]);

        return 0;
    }
}
