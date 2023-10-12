<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Common\Update;
use SergiX44\Nutgram\Telegram\Types\Common\WebhookInfo;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

/**
 * @mixin Client
 */
trait UpdateMethods
{
    /**
     * Use this method to receive incoming updates using long polling.
     * An Array of Update objects is returned.
     * @see https://core.telegram.org/bots/api#getupdates
     * @see https://en.wikipedia.org/wiki/Push_technology#Long_polling
     * @param int|null $offset
     * @param int|null $limit
     * @param int|null $timeout
     * @param string[]|null $allowed_updates
     * @return array|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function getUpdates(?int $offset = null, ?int $limit = null, ?int $timeout = null, ?array $allowed_updates = null): ?array
    {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars(), Update::class, [
            'timeout' => ($timeout ?? $this->config->pollingTimeout) + 1
        ]);
    }

    /**
     * @param string $url
     * @param InputFile|null $certificate
     * @param string|null $ip_address
     * @param int|null $max_connections
     * @param string[]|null $allowed_updates
     * @param bool|null $drop_pending_updates
     * @param string|null $secret_token
     * @return bool|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function setWebhook(
        string $url,
        ?InputFile $certificate = null,
        ?string $ip_address = null,
        ?int $max_connections = null,
        ?array $allowed_updates = null,
        ?bool $drop_pending_updates = null,
        ?string $secret_token = null
    ): ?bool {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars());
    }

    /**
     * @param bool $drop_pending_updates
     * @return bool|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function deleteWebhook(?bool $drop_pending_updates = null): ?bool
    {
        return $this->prepareAndSendRequest(__FUNCTION__, get_defined_vars());
    }

    /**
     * @return WebhookInfo|null
     * @throws GuzzleException
     * @throws JsonException
     * @throws TelegramException
     */
    public function getWebhookInfo(): ?WebhookInfo
    {
        return $this->prepareAndSendRequest(__FUNCTION__, mapTo: WebhookInfo::class);
    }
}
