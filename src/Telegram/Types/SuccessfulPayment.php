<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains basic information about a successful payment.
 * @see https://core.telegram.org/bots/api#successfulpayment
 */
class SuccessfulPayment
{
    /**
     * Three-letter ISO 4217 {@see https://core.telegram.org/bots/payments#supported-currencies currency} code
     * @var string
     */
    public string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in
     * {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of
     * digits past the decimal point for each currency (2 for the majority of currencies).
     * @var int
     */
    public int $total_amount;

    /**
     * Bot specified invoice payload
     * @var string
     */
    public string $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     * @var string
     */
    public string $shipping_option_id;

    /**
     * Optional. Order info provided by the user
     * @var OrderInfo
     */
    public OrderInfo $order_info;

    /**
     * Telegram payment identifier
     * @var string
     */
    public string $telegram_payment_charge_id;

    /**
     * Provider payment identifier
     * @var string
     */
    public string $provider_payment_charge_id;
}
