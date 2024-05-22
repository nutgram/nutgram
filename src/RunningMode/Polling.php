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

    private static int $offset = 1;

    private function getOffset()
    {
        return self::$offset;
    }

    private function setOffset($offset)
    {
        return self::$offset = $offset;
    }

    public function __construct()
    {
        if (!(\PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg')) {
            throw new RuntimeException('This mode can be only invoked via cli.');
        }
    }

    public function processUpdates(Nutgram $bot): void
    {
        $this->listenForSignals();
        print("Listening...\n");
        while (self::$FOREVER) {

             $this->processUpdate($bot);
        }
    }

    public function processUpdate(Nutgram $bot): void
    {
        $updates = $bot->getUpdates(
            offset: $this->getOffset(),
            limit: $bot->getConfig()->pollingLimit,
            timeout: $bot->getConfig()->pollingTimeout,
            allowed_updates: $bot->getConfig()->pollingAllowedUpdates
        );

        if ($updates) {
            $this->setOffset(end($updates)->update_id + 1);

            $this->fire($bot, $updates);
        }
    }

    private function listenForSignals(): void
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
