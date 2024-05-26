<?php

namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

class SingleUpdate extends Polling
{
    private static int $offset = 1;

    public function processUpdates(Nutgram $bot): void
    {
        $this->listenForSignals();
        $config = $bot->getConfig();

        if (self::$offset === 1) {
            $lastUpdates = $bot->getUpdates(
                offset: self::$offset,
                limit: $config->pollingLimit,
                timeout: $config->pollingTimeout,
                allowed_updates: $config->pollingAllowedUpdates
            );

            /** @var Update $last */
            $last = end($lastUpdates);
            if ($last) {
                self::$offset = $last->update_id;
            }
        }

        $updates = $bot->getUpdates(
            offset: self::$offset,
            limit: $config->pollingLimit,
            timeout: $config->pollingTimeout,
            allowed_updates: $config->pollingAllowedUpdates
        );

        self::$offset += count($updates);

        $this->fire($bot, $updates);
    }

    public static function resetOffset(): void
    {
        self::$offset = 1;
    }
}
