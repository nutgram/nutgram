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
     * @var string $url
     */
    public $url;
    
    /**
     * True, if a custom certificate was provided for webhook certificate checks
     * @var bool $has_custom_certificate
     */
    public $has_custom_certificate;
    
    /**
     * Number of updates awaiting delivery
     * @var int $pending_update_count
     */
    public $pending_update_count;

    /**
     * Optional. Currently used webhook IP address
     * @var string $ip_address
     */
    public $ip_address;
    
    /**
     * Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook
     * @var int $last_error_date
     */
    public $last_error_date;
    
    /**
     * Optional. Error message in human-readable format for the most recent error that happened
     * when trying to deliver an update via webhook
     * @var string $last_error_message
     */
    public $last_error_message;
    
    /**
     * Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
     * @var int $max_connections
     */
    public $max_connections;
    
    /**
     * Optional. A list of update types the bot is subscribed to. Defaults to all update types
     * @var string[] $allowed_updates
     */
    public $allowed_updates;
}
