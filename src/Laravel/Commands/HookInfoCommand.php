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

        $this->table(['Info', 'Value'], [
            ['url', $info->url],
            ['has_custom_certificate', $info->has_custom_certificate ? 'true' : 'false'],
            ['pending_update_count', $info->pending_update_count],
            ['ip_address', $info->ip_address],
            ['last_error_date', $info->last_error_date],
            ['last_error_message', $info->last_error_message],
            ['max_connections', $info->max_connections],
            ['allowed_updates', implode(', ', $info->allowed_updates ?: [])],
        ]);

        return 0;
    }
}
