<?php

namespace SergiX44\Nutgram\Telegram\Types\Payment;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption
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
    public array $prices;
}
