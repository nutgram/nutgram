<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes an amount of Telegram Stars.
 * @see https://core.telegram.org/bots/api#staramount
 */
class StarAmount extends BaseType
{
    /**
     * Integer amount of Telegram Stars, rounded to 0; can be negative
     */
    public int $amount;
    /**
     * Optional. The number of 1/1000000000 shares of Telegram Stars; from -999999999 to 999999999; can be negative if and only if amount is non-positive
     */
    public ?int $nanostar_amount = null;
}
