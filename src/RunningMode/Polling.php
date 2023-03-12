<?php


namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Polling implements RunningMode
{

    /**
     * @param  Nutgram  $bot
     */
    public function processUpdates(Nutgram $bot): void
    {
        $config = $bot->getConfig();
        $allowedUpdates = !empty($config->pollingAllowedUpdates) ? ['allowed_updates' => $config->pollingAllowedUpdates] : [];

        $parameters = [
            'limit' => $config->pollingLimit,
            'timeout' => $config->pollingTimeout,
            ...$allowedUpdates,
        ];

        $offset = 1;
        echo "Listening...\n";
        while (true) {
            $updates = $bot->getUpdates(['offset' => $offset, ...$parameters]);

            if ($offset === 1) {
                /** @var Update $last */
                $last = end($updates);
                if ($last) {
                    $offset = $last->update_id;
                }

                continue;
            }

            $offset += count($updates);

            $this->fire($bot, $updates);
        }
    }

    /**
     * @param  Nutgram  $bot
     * @param  Update[]  $updates
     * @return void
     */
    protected function fire(Nutgram $bot, array $updates = []): void
    {
        foreach ($updates as $update) {
            try {
                $bot->processUpdate($update);
            } catch (Throwable $e) {
                echo "$e\n";
            } finally {
                $bot->clearData();
            }
        }
    }
}
