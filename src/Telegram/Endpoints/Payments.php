<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use JsonException;
use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * Trait Payments
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Payments
{
    /**
     * Use this method to send invoices.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendinvoice
     * @param  string  $title Product name, 1-32 characters
     * @param  string  $description Product description, 1-255 characters
     * @param  string  $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use
     *     for your internal processes.
     * @param  string  $provider_token Payments provider token, obtained via {@see https://t.me/botfather Botfather}
     * @param  string  $currency Three-letter ISO 4217 currency code, see
     *     {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @param  array  $prices Price breakdown, a list of components (e.g. product price, tax, discount, delivery cost,
     *     delivery tax, bonus, etc.)
     * @param  array|null  $opt
     * @return Message|null
     * @throws JsonException
     */
    public function sendInvoice(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        ?array $opt = []
    ): ?Message {
        $chat_id = $this->chatId();
        $required = compact('chat_id', 'title', 'description', 'payload', 'provider_token', 'currency');
        $required['prices'] = json_encode($prices, JSON_THROW_ON_ERROR);
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * Use this method to create a link for an invoice. Returns the created invoice link as String on success.
     * @see https://core.telegram.org/bots/api#createinvoicelink
     * @param  string  $title Product name, 1-32 characters
     * @param  string  $description Product description, 1-255 characters
     * @param  string  $payload Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @param  string  $provider_token Payment provider token, obtained via {@see https://t.me/botfather BotFather}
     * @param  string  $currency Three-letter ISO 4217 currency code, see {@see https://core.telegram.org/bots/payments#supported-currencies more on currencies}
     * @param  array  $prices Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @return string
     */
    public function createInvoiceLink(
        string $title,
        string $description,
        string $payload,
        string $provider_token,
        string $currency,
        array $prices,
        ?array $opt = []
    ): string {
        $required = compact('title', 'description', 'payload', 'provider_token', 'currency', 'prices');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API
     * will send an {@see https://core.telegram.org/bots/api#update Update} with a shipping_query field to the bot.
     * Use this method to reply to shipping queries. On success, True is returned.
     * @see https://core.telegram.org/bots/api#answershippingquery
     * @param  bool  $ok Specify True if delivery to the specified address is possible and False if there are any
     *     problems (for example, if delivery to the specified address is not possible)
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
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation
     * in the form of an {@see https://core.telegram.org/bots/api#update Update} with the field pre_checkout_query.
     * Use this method to respond to such pre-checkout queries.
     * On success, True is returned.
     * Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query was sent.
     * @see https://core.telegram.org/bots/api#answerprecheckoutquery
     * @param  bool  $ok Specify True if everything is alright (goods are available, etc.) and the bot is ready to
     *     proceed with the order. Use False if there are any problems.
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
