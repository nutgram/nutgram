<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Message;

/**
 * Trait Payments
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Payments
{
    /**
     * @param  string  $title
     * @param  string  $description
     * @param  string  $payload
     * @param  string  $provider_token
     * @param  string  $start_parameter
     * @param  string  $currency
     * @param  array  $prices
     * @param  array|null  $opt
     * @return Message|null
     */
    public function sendInvoice(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $start_parameter,
        string $currency,
        array $prices,
        ?array $opt = []
    ): ?Message {
        $chat_id = $this->chatId();
        $required = compact('chat_id', 'title', 'description', 'payload', 'provider_token', 'start_parameter', 'currency');
        $required['prices'] = json_encode($prices);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  bool  $ok
     * @param  array|null  $opt
     * @return bool|null
     */
    public function answerShippingQuery(bool $ok, ?array $opt = []): ?bool
    {
        $required = [
            'shipping_query_id' => $this->shippingQuery()?->id,
            'ok' => $ok,
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  bool  $ok
     * @param  array|null  $opt
     * @return bool|null
     */
    public function answerPreCheckoutQuery(bool $ok, ?array $opt = []): ?bool
    {
        $required = [
            'pre_checkout_query_id' => $this->preCheckoutQuery()?->id,
            'ok' => $ok,
        ];
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }
}
