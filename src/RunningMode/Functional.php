<?php

namespace SergiX44\Nutgram\RunningMode;

use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use Throwable;

class Functional implements RunningMode
{
    /**
     *
     * @param Nutgram $bot
     * @param (string|null) ...$args
     * @return void
     */
    public function processUpdates(Nutgram $bot, ...$args): void
    {
        foreach ($args as $arg) {
            if ($arg  === null) {
                return;
            }

            $update = null;
            try {
                $update = $bot->getContainer()
                    ->get(Hydrator::class)
                    ->hydrate(json_decode($arg, true, flags: JSON_THROW_ON_ERROR), Update::class);
                $bot->processUpdate($update);
            } catch (Throwable $e) {
                $bot->getContainer()
                    ->get(LoggerInterface::class)
                    ->error(sprintf('Update failed: %s%s%s', $update?->getType()?->value, PHP_EOL, $this->$arg), ['exception' => $e]);
                throw $e;
            }
        }
    }
}
