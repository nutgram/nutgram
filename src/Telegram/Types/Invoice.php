<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object contains basic information about an invoice.
 * @see https://core.telegram.org/bots/api#invoice
 */
class Invoice
{
    /**
     * Product name
     * @var string
     */
    public string $title;
    
    /**
     * Product description
     * @var string
     */
    public string $description;
    
    /**
     * Unique bot deep-linking parameter that can be used to generate this invoice
     * @var string
     */
    public string $start_parameter;
    
    /**
     * Three-letter ISO 4217 {@see https://core.telegram.org/bots/payments#supported-currencies currency} code
     * @var string
     */
    public string $currency;
    
    /**
     * Price of the product in the smallest units of the
     * {@see https://core.telegram.org/bots/payments#supported-currencies currency} (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json},
     * it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * @var int
     */
    public int $total_amount;
}
