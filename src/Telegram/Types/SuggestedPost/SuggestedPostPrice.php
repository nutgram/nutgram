<?php

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Nutgram\Telegram\Types\BaseType;

class SuggestedPostPrice extends BaseType
{

    /**
     * Currency in which the post will be paid.
     * Currently, must be one of “XTR” for Telegram Stars or “TON” for toncoins
     */
    public string $currency;

    /**
     * The amount of the currency that will be paid for the post in the smallest units of the currency,
     * i.e. Telegram Stars or nanotoncoins.
     * Currently, price in Telegram Stars must be between 5 and 100000,
     * and price in nanotoncoins must be between 10000000 and 10000000000000.
     */
    public int $amount;

    public function __construct(string $currency, int $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
        parent::__construct();
    }

    public static function make(string $currency, int $amount): self
    {
        return new self($currency, $amount);
    }
}
