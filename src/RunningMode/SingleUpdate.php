<?php

namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;

class SingleUpdate extends Polling
{
    public function processUpdates(Nutgram $bot): void
    {
        $this->listenForSignals();
        $config = $bot->getConfig();

        $updates = $bot->getUpdates(
            offset: -1,
            limit: 1,
            timeout: $config->pollingTimeout,
            allowed_updates: $config->pollingAllowedUpdates
        );

        $this->fire($bot, $updates);

        if (empty($updates)) {
            return;
        }

        $bot->getUpdates(
            offset: end($updates)?->update_id + 1,
            limit: 1,
            timeout: 0,
            allowed_updates: $config->pollingAllowedUpdates
        );
    }
}
