<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one shipping option.
 * @see https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption
{
    /**
     * Shipping option identifier
     * @var string
     */
    public string $id;

    /**
     * Option title
     * @var string
     */
    public string $title;

    /**
     * List of price portions
     * @var LabeledPrice[]
     */
    public array $prices;
}
