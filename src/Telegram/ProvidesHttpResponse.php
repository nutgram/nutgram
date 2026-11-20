<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram;

use SergiX44\Nutgram\RunningMode\RespondsToWebhook;
use SergiX44\Nutgram\RunningMode\RunningMode;

trait ProvidesHttpResponse
{
    protected bool $enableAsResponse = false;

    public function asResponse(): self
    {
        $this->enableAsResponse = true;
        return $this;
    }

    /**
     * Hands the request to the running mode as the response to the current update,
     * when asResponse() was called before it and the running mode can still respond.
     * @param array<array-key, mixed> $parameters
     */
    protected function respondAsWebhook(string $method, array $parameters): bool
    {
        if (!$this->enableAsResponse) {
            return false;
        }

        $this->enableAsResponse = false;

        $runningMode = $this->container->get(RunningMode::class);
        if (!$runningMode instanceof RespondsToWebhook || !$runningMode->canRespond()) {
            return false;
        }

        $runningMode->respond($method, $parameters);

        return true;
    }
}
