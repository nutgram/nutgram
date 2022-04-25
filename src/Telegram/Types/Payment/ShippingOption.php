<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption extends BaseType
{
    /**
     * Shipping option identifier
     */
    public string $id;

    /**
     * Option title
     */
    public string $title;

    /**
     * List of price portions
     * @var \SergiX44\Nutgram\Telegram\Types\Payment\LabeledPrice[] $prices
     */
    #[ArrayType(LabeledPrice::class)]
    public array $prices;
}
