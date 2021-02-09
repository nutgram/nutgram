<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Contains information about the current status of a webhook.
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfo
{
    /**
     * Webhook URL, may be empty if webhook is not set up
     * @var string
     */
    public string $url;
    
    /**
     * True, if a custom certificate was provided for webhook certificate checks
     * @var bool
     */
    public bool $has_custom_certificate;
    
    /**
     * Number of updates awaiting delivery
     * @var int
     */
    public int $pending_update_count;

    /**
     * Optional. Currently used webhook IP address
     * @var string
     */
    public string $ip_address;
    
    /**
     * Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook
     * @var int
     */
    public int $last_error_date;
    
    /**
     * Optional. Error message in human-readable format for the most recent error that happened
     * when trying to deliver an update via webhook
     * @var string
     */
    public string $last_error_message;
    
    /**
     * Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
     * @var int
     */
    public int $max_connections;
    
    /**
     * Optional. A list of update types the bot is subscribed to. Defaults to all update types
     * @var string[]
     */
    public array $allowed_updates;
}
