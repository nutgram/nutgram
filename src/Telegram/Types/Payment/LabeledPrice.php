<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a portion of the price for goods or services.
 * @see https://core.telegram.org/bots/api#labeledprice
 */
class LabeledPrice extends BaseType
{
    /**
     * Portion label
     */
    public string $label;

    /**
     * Price of the product in the smallest units of the
     * {@see https://core.telegram.org/bots/payments#supported-currencies currency} (integer, not float/double).
     * For example, for a price of US$ 1.45 pass amount = 145.
     * See the exp parameter in {@see https://core.telegram.org/bots/payments/currencies.json currencies.json},
     * it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     */
    public int $amount;
}
