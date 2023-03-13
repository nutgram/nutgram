<?php


namespace SergiX44\Nutgram\RunningMode;

use Psr\SimpleCache\InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Polling implements RunningMode
{
    /**
     * @param  Nutgram  $bot
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \SergiX44\Nutgram\Telegram\Exceptions\TelegramException
     */
    public function processUpdates(Nutgram $bot): void
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
