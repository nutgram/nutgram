<?php


namespace SergiX44\Nutgram\RunningMode;

use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Polling implements RunningMode
{
    public static bool $FOREVER = true;
    public static mixed $STDERR = null;

    public function __construct()
    {
        if (!(\PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg')) {
            throw new RuntimeException('This mode can be only invoked via cli.');
        }
    }

    public function processUpdates(Nutgram $bot): void
    {
        $this->listenForSignals();

        $config = $bot->getConfig();
        $offset = 1;

        print("Listening...\n");
        while (self::$FOREVER) {
            $updates = $bot->getUpdates(
                offset: $offset,
                limit: $config->pollingLimit,
                timeout: $config->pollingTimeout,
                allowed_updates: $config->pollingAllowedUpdates
            );

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

    protected function listenForSignals(): void
    {
        if (extension_loaded('pcntl')) {
            pcntl_async_signals(true);

            pcntl_signal(SIGINT, function () {
                self::$FOREVER = false;
            });

            pcntl_signal(SIGTERM, function () {
                self::$FOREVER = false;
            });
        }
    }

    /**
     * @param Nutgram $bot
     * @param Update[] $updates
     * @return void
     */
    protected function fire(Nutgram $bot, array $updates = []): void
    {
        foreach ($updates as $update) {
            try {
                $bot->processUpdate($update);
            } catch (Throwable $e) {
                fwrite(self::$STDERR ?? STDERR, "$e\n");
            } finally {
                $bot->clear();
            }
        }
    }
}
