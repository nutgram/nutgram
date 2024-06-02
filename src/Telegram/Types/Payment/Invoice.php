<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains basic information about an invoice.
 * @see https://core.telegram.org/bots/api#invoice
 */
class Invoice extends BaseType
{
    /** Product name */
    public string $title;

    /** Product description */
    public string $description;

    /** Unique bot deep-linking parameter that can be used to generate this invoice */
    public string $start_parameter;

    /**
     * Three-letter ISO 4217 {@see https://core.telegram.org/bots/payments#supported-currencies currency} code,
     * or “XTR” for payments in {@see https://t.me/BotNews/90 Telegram Stars}.
     */
    public string $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json}, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     */
    public int $total_amount;
}
