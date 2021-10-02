<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

/**
 * This object contains basic information about an invoice.
 * @see https://core.telegram.org/bots/api#invoice
 */
class Invoice
{
    /**
     * Product name
     * @var string $title
     */
    public $title;

    /**
     * Product description
     * @var string $description
     */
    public $description;

    /**
     * Unique bot deep-linking parameter that can be used to generate this invoice
     * @var string $start_parameter
     */
    public $start_parameter;

    /**
     * Three-letter ISO 4217 {@see https://core.telegram.org/bots/payments#supported-currencies currency} code
     * @var string $currency
     */
    public $currency;

    /**
     * Price of the product in the smallest units of the
     * {@see https://core.telegram.org/bots/payments#supported-currencies currency} (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json},
     * it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * @var int $total_amount
     */
    public $total_amount;
}
