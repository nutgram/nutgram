<?php

namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class SingleUpdate extends Polling
{
    public function processUpdates(Nutgram $bot): void
    {
        $this->listenForSignals();
        $config = $bot->getConfig();

        $lastUpdates = $bot->getUpdates(
            offset: -1,
            limit: 1,
            timeout: $config->pollingTimeout,
            allowed_updates: $config->pollingAllowedUpdates
        );

        /** @var Update $last */
        $last = end($lastUpdates);
        $offset = $last ? $last->update_id + 1 : -1;

        $updates = $bot->getUpdates(
            offset: $offset,
            limit: 1,
            timeout: $config->pollingTimeout,
            allowed_updates: $config->pollingAllowedUpdates
        );

        $this->fire($bot, $updates);
    }
}
