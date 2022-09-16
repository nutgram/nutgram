<?php

namespace SergiX44\Nutgram\Laravel\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

class HookInfoCommand extends Command
{
    protected $signature = 'nutgram:hook:info';

    protected $description = 'Get current webhook status';

    /**
     * @throws TelegramException
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handle(Nutgram $bot): int
    {
        $webhookInfo = $bot->getWebhookInfo();

        if ($webhookInfo === null) {
            $this->error('Unable to get webhook info');
            return 1;
        }

        $lastErrorDate = null;
        if ($webhookInfo->last_error_date !== null) {
            $lastErrorDate = date('Y-m-d H:i:s', $webhookInfo->last_error_date).' UTC';
        }

        $lastSynchronizationErrorDate = null;
        if ($webhookInfo->last_synchronization_error_date !== null) {
            $lastSynchronizationErrorDate = date('Y-m-d H:i:s', $webhookInfo->last_synchronization_error_date).' UTC';
        }

        $this->table(['Info', 'Value'], [
            ['url', $webhookInfo->url],
            ['has_custom_certificate', $webhookInfo->has_custom_certificate ? 'true' : 'false'],
            ['pending_update_count', $webhookInfo->pending_update_count],
            ['ip_address', $webhookInfo->ip_address],
            ['last_error_date', $lastErrorDate],
            ['last_error_message', $webhookInfo->last_error_message],
            ['last_synchronization_error_date', $lastSynchronizationErrorDate],
            ['max_connections', $webhookInfo->max_connections],
            ['allowed_updates', implode(', ', $webhookInfo->allowed_updates ?: [])],
        ]);

        return 0;
    }
}
