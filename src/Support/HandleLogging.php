<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Support;

use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Nutgram;

/**
 * @mixin Nutgram
 */
trait HandleLogging
{
    protected function logRequest(string $endpoint, array $content, array $options): void
    {
        $this->container
            ->get(LoggerInterface::class)
            ->debug('⬆️ Nutgram Request', [
                'endpoint' => $endpoint,
                'content' => $content,
                'options' => $options,
                'type' => 'request',
            ]);
    }

    protected function logResponse(string $response): void
    {
        try {
            $response = json_decode(
                json: $response,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
        } catch (\JsonException) {
        }

        $this->container
            ->get(LoggerInterface::class)
            ->debug('⬇️ Nutgram Response', [
                'response' => $response,
                'type' => 'response',
            ]);
    }
}
