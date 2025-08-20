<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\SuggestedPost;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\Currency;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the price of a suggested post.
 * @see https://core.telegram.org/bots/api#suggestedpostprice
 */
#[OverrideConstructor('bindToInstance')]
class SuggestedPostPrice extends BaseType
{
    /**
     * Currency in which the post will be paid.
     * Currently, must be one of “XTR” for Telegram Stars or “TON” for toncoins
     */
    #[EnumOrScalar]
    public Currency|string $currency;

    /**
     * The amount of the currency that will be paid for the post in the smallest units of the currency,
     * i.e. Telegram Stars or nanotoncoins.
     * Currently, price in Telegram Stars must be between 5 and 100000,
     * and price in nanotoncoins must be between 10000000 and 10000000000000.
     */
    public int $amount;

    public function __construct(Currency|string $currency, int $amount)
    {
        parent::__construct();
        $this->currency = $currency;
        $this->amount = $amount;
    }
}
