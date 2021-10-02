<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

/**
 * This object contains basic information about a successful payment.
 * @see https://core.telegram.org/bots/api#successfulpayment
 */
class SuccessfulPayment
{
    /**
     * Three-letter ISO 4217 {@see https://core.telegram.org/bots/payments#supported-currencies currency} code
     * @var string $currency
     */
    public $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in
     * {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of
     * digits past the decimal point for each currency (2 for the majority of currencies).
     * @var int $total_amount
     */
    public $total_amount;

    /**
     * Bot specified invoice payload
     * @var string $invoice_payload
     */
    public $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     * @var string $shipping_option_id
     */
    public $shipping_option_id;

    /**
     * Optional. Order info provided by the user
     * @var OrderInfo $order_info
     */
    public $order_info;

    /**
     * Telegram payment identifier
     * @var string $telegram_payment_charge_id
     */
    public $telegram_payment_charge_id;

    /**
     * Provider payment identifier
     * @var string $provider_payment_charge_id
     */
    public $provider_payment_charge_id;
}
