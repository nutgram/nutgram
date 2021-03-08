<?php


namespace SergiX44\Nutgram\RunningMode;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Update;
use Throwable;

class Polling implements RunningMode
{

    /**
     * @param  Nutgram  $bot
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function processUpdates(Nutgram $bot)
    {
        $pollingConfig = $bot->getConfig()['polling'] ?? [];
        $timeout = $pollingConfig['timeout'] ?? $bot->getConfig()['timeout'] ?? 10;
        $allowedUpdates = isset($pollingConfig['allowed_updates']) ? ['allowed_updates' => $pollingConfig['allowed_updates']] : [];


        $parameters = array_merge([
            'limit' => $pollingConfig['limit'] ?? 100,
            'timeout' => $timeout,
        ], $allowedUpdates);

        $offset = 1;
        echo "Listening...\n";
        while (true) {
            $updates = $bot->getUpdates(array_merge(['offset' => $offset], $parameters));

            if ($offset === 1) {
                /** @var Update $last */
                $last = end($updates);
                if ($last) {
                    $offset = $last->update_id;
                }

                continue;
            }

            /** @var Update $update */
            foreach ($updates as $update) {
                $offset++;
                try {
                    $bot->processUpdate($update);
                } catch (Throwable $e) {
                    echo "{$e}\n";
                } finally {
                    $bot->clearData();
                }
            }
        }
    }
}
