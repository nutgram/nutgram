<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\RunningMode;

/**
 * A running mode that can send a Bot API call as the response to the incoming update,
 * used by {@see \SergiX44\Nutgram\Nutgram::asResponse()}.
 */
interface RespondsToWebhook
{
    public function canRespond(): bool;

    /**
     * @param array<array-key, mixed> $parameters
     */
    public function respond(string $method, array $parameters): void;
}
